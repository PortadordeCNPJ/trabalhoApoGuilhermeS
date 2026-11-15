<?php

namespace app\models;

use PDO;

class Frete
{
    // Busca os dados para preencher o formulário.
    public static function dadosFormulario(PDO $pdo): array
    {
        $transportadores = $pdo->query("
            SELECT id_transportador, nome, tipo_veiculo, placa
            FROM transportadores
            WHERE ativo = 1
            ORDER BY nome
        ")->fetchAll(PDO::FETCH_ASSOC);

        $enderecos = $pdo->query("
            SELECT id_endereco, identificacao, logradouro,
                   numero, cidade, estado
            FROM enderecos
            ORDER BY identificacao
        ")->fetchAll(PDO::FETCH_ASSOC);

        $produtos = $pdo->query("
            SELECT id_produto, nome, quantidade_estoque
            FROM produtos
            WHERE quantidade_estoque > 0
            ORDER BY nome
        ")->fetchAll(PDO::FETCH_ASSOC);

        return [
            'transportadores' => $transportadores,
            'enderecos' => $enderecos,
            'produtos' => $produtos
        ];
    }

    // Cadastra o frete e os produtos em uma única transação.
    public static function cadastrar(
        PDO $pdo,
        array $dados,
        array $produtos
    ): int {
        $pdo->beginTransaction();

        try {
            // Confere se o transportador está ativo.
            $stmt = $pdo->prepare("
                SELECT id_transportador
                FROM transportadores
                WHERE id_transportador = :id
                  AND ativo = 1
            ");
            $stmt->execute([':id' => $dados['transportador_id']]);

            if (!$stmt->fetch()) {
                throw new \RuntimeException('Transportador inválido ou inativo.');
            }

            // Confere se os endereços existem.
            $stmtEndereco = $pdo->prepare("
                SELECT id_endereco
                FROM enderecos
                WHERE id_endereco = :id
            ");

            foreach ([
                $dados['endereco_origem_id'],
                $dados['endereco_destino_id']
            ] as $idEndereco) {
                $stmtEndereco->execute([':id' => $idEndereco]);

                if (!$stmtEndereco->fetch()) {
                    throw new \RuntimeException('Um dos endereços selecionados não existe.');
                }
            }

            // Cria o registro principal do frete.
            $sqlFrete = "
                INSERT INTO fretes (
                    transportador_id,
                    endereco_origem_id,
                    endereco_destino_id,
                    usuario_id,
                    data_frete,
                    valor_frete,
                    status,
                    observacoes
                ) VALUES (
                    :transportador,
                    :origem,
                    :destino,
                    :usuario,
                    :data_frete,
                    :valor,
                    'Pendente',
                    :observacoes
                )
            ";

            $stmtFrete = $pdo->prepare($sqlFrete);

            $stmtFrete->execute([
                ':transportador' => $dados['transportador_id'],
                ':origem' => $dados['endereco_origem_id'],
                ':destino' => $dados['endereco_destino_id'],
                ':usuario' => $dados['usuario_id'],
                ':data_frete' => $dados['data_frete'],
                ':valor' => $dados['valor_frete'],
                ':observacoes' => $dados['observacoes']
            ]);

            $idFrete = (int) $pdo->lastInsertId();

            // Prepara os comandos para os produtos.
            $stmtEstoque = $pdo->prepare("
                SELECT quantidade_estoque
                FROM produtos
                WHERE id_produto = :id
                FOR UPDATE
            ");

            $stmtVinculo = $pdo->prepare("
                INSERT INTO frete_produtos (
                    frete_id,
                    produto_id,
                    quantidade
                ) VALUES (
                    :frete,
                    :produto,
                    :quantidade
                )
            ");

            $stmtAtualizaEstoque = $pdo->prepare("
                UPDATE produtos
                SET quantidade_estoque = quantidade_estoque - :quantidade
                WHERE id_produto = :id
            ");

            foreach ($produtos as $produto) {
                $idProduto = (int) $produto['id_produto'];
                $quantidade = (int) $produto['quantidade'];

                $stmtEstoque->execute([':id' => $idProduto]);
                $estoque = $stmtEstoque->fetchColumn();

                if ($estoque === false) {
                    throw new \RuntimeException('Um dos produtos selecionados não existe.');
                }

                if ($quantidade > (int) $estoque) {
                    throw new \RuntimeException(
                        'Estoque insuficiente para um dos produtos selecionados.'
                    );
                }

                // Relaciona o produto ao frete.
                $stmtVinculo->execute([
                    ':frete' => $idFrete,
                    ':produto' => $idProduto,
                    ':quantidade' => $quantidade
                ]);

                // Reserva as unidades, diminuindo o estoque.
                $stmtAtualizaEstoque->execute([
                    ':quantidade' => $quantidade,
                    ':id' => $idProduto
                ]);
            }

            $pdo->commit();

            return $idFrete;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $e;
        }
    }

    // Lista os fretes com seus dados relacionados.
    public static function listar(PDO $pdo): array
    {
        $sql = "
            SELECT
                f.id_frete,
                f.data_frete,
                f.valor_frete,
                f.status,
                t.nome AS transportador,
                eo.identificacao AS origem,
                ed.identificacao AS destino,
                GROUP_CONCAT(
                    CONCAT(p.nome, ' (', fp.quantidade, ')')
                    SEPARATOR ', '
                ) AS produtos
            FROM fretes f
            INNER JOIN transportadores t
                ON t.id_transportador = f.transportador_id
            INNER JOIN enderecos eo
                ON eo.id_endereco = f.endereco_origem_id
            INNER JOIN enderecos ed
                ON ed.id_endereco = f.endereco_destino_id
            LEFT JOIN frete_produtos fp
                ON fp.frete_id = f.id_frete
            LEFT JOIN produtos p
                ON p.id_produto = fp.produto_id
            GROUP BY
                f.id_frete,
                f.data_frete,
                f.valor_frete,
                f.status,
                t.nome,
                eo.identificacao,
                ed.identificacao
            ORDER BY f.id_frete DESC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
