<?php

namespace app\controllers;

use DateTimeImmutable;
use app\models\Connection;
use app\models\Frete;
use PDOException;
use PDO;

class FreteController
{
    // Prepara os dados para a tela.
    public static function index(): array
    {
        $pdo = Connection::connect();

        return [
            'dados' => Frete::dadosFormulario($pdo),
            'fretes' => Frete::listar($pdo)
        ];
    }

    // Processa o cadastro.
    public static function cadastrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=frete');
            exit;
        }

        $transportador = (int) ($_POST['transportador_id'] ?? 0);
        $origem = (int) ($_POST['endereco_origem_id'] ?? 0);
        $destino = (int) ($_POST['endereco_destino_id'] ?? 0);
        $data = trim($_POST['data_frete'] ?? '');
        $valor = str_replace(',', '.', trim($_POST['valor_frete'] ?? ''));
        $observacoes = trim($_POST['observacoes'] ?? '');

        $produtos = $_POST['produtos'] ?? [];
        $erros = [];

        if ($transportador <= 0) {
            $erros[] = 'Selecione um transportador.';
        }

        if ($origem <= 0 || $destino <= 0) {
            $erros[] = 'Selecione os endereços de origem e destino.';
        }

        if ($origem > 0 && $origem === $destino) {
            $erros[] = 'A origem e o destino não podem ser iguais.';
        }

        $dataObj = \DateTime::createFromFormat('!Y-m-d', $data);

        if (!$dataObj || $dataObj->format('Y-m-d') !== $data) {
            $erros[] = 'Informe uma data válida.';
        }

        if (!is_numeric($valor) || (float) $valor < 0) {
            $erros[] = 'Informe um valor de frete válido.';
        }

        if (!is_array($produtos) || count($produtos) === 0) {
            $erros[] = 'Adicione pelo menos um produto ao frete.';
        }

        $produtosValidados = [];
        $idsAdicionados = [];

        if (is_array($produtos)) {
            foreach ($produtos as $produto) {
                if (!is_array($produto)) {
                    $erros[] = 'Dados de produto inválidos.';
                    continue;
                }

                $idProduto = filter_var(
                    $produto['id_produto'] ?? null,
                    FILTER_VALIDATE_INT
                );

                $quantidade = filter_var(
                    $produto['quantidade'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if (
                    !$idProduto || $idProduto <= 0 ||
                    !$quantidade || $quantidade <= 0
                ) {
                    $erros[] = 'Confira os produtos e suas quantidades.';
                    continue;
                }

                if (isset($idsAdicionados[$idProduto])) {
                    $erros[] = 'Não adicione o mesmo produto mais de uma vez.';
                    continue;
                }

                $idsAdicionados[$idProduto] = true;

                $produtosValidados[] = [
                    'id_produto' => $idProduto,
                    'quantidade' => $quantidade
                ];
            }
        }

        // O ID do usuário logado será gravado no frete.
        $usuarioId = (int) ($_SESSION['id_usuario'] ?? 0);

        if ($usuarioId <= 0) {
            $erros[] = 'Não foi possível identificar o usuário logado.';
        }

        if (!empty($erros)) {
            $_SESSION['erros_frete'] = $erros;
            header('Location: index.php?pagina=frete');
            exit;
        }

        try {
            $pdo = Connection::connect();

            $dados = [
                'transportador_id' => $transportador,
                'endereco_origem_id' => $origem,
                'endereco_destino_id' => $destino,
                'usuario_id' => $usuarioId,
                'data_frete' => $data,
                'valor_frete' => (float) $valor,
                'observacoes' => $observacoes
            ];

            $idFrete = Frete::cadastrar(
                $pdo,
                $dados,
                $produtosValidados
            );

            $_SESSION['sucesso_frete'] =
                "Frete #{$idFrete} cadastrado com sucesso!";
        } catch (\RuntimeException $e) {
            $_SESSION['erros_frete'] = [$e->getMessage()];
        } catch (PDOException $e) {
            error_log($e->getMessage());

            $_SESSION['erros_frete'] = [
                'Erro no banco de dados ao cadastrar o frete.'
            ];
        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $_SESSION['erros_frete'] = [
                'Não foi possível cadastrar o frete.'
            ];
        }

        header('Location: index.php?pagina=frete');
        exit;
    }


    public static function exportarRelatorio(): void
    {
        $data = $_GET['data'] ?? '';

        // Validação da data recebida
        $dataValidada = DateTimeImmutable::createFromFormat('!Y-m-d', $data);
        $errosData = DateTimeImmutable::getLastErrors();

        if (
            !$dataValidada ||
            ($errosData !== false &&
                ($errosData['warning_count'] > 0 || $errosData['error_count'] > 0)) ||
            $dataValidada->format('Y-m-d') !== $data
        ) {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode([
                'mensagem' => 'Data inválida.'
            ]);

            return;
        }

        try {

            $pdo = Connection::connect();

            $sql = "SELECT
                    f.id_frete,
                    t.nome AS transportador,
                    origem.identificacao AS origem,
                    destino.identificacao AS destino,
                    f.data_frete,
                    f.valor_frete,
                    f.status,
                    f.observacoes,
                    GROUP_CONCAT(
                        CONCAT(p.nome, ' (Quantidade: ', fp.quantidade, ')')
                        ORDER BY p.nome
                        SEPARATOR ', '
                    ) AS produtos

                FROM fretes f

                INNER JOIN transportadores t
                    ON t.id_transportador = f.transportador_id

                INNER JOIN enderecos origem
                    ON origem.id_endereco = f.endereco_origem_id

                INNER JOIN enderecos destino
                    ON destino.id_endereco = f.endereco_destino_id

                LEFT JOIN frete_produtos fp
                    ON fp.frete_id = f.id_frete

                LEFT JOIN produtos p
                    ON p.id_produto = fp.produto_id

                WHERE f.data_frete >= :inicio
                  AND f.data_frete < :fim

                GROUP BY
                    f.id_frete,
                    t.nome,
                    origem.identificacao,
                    destino.identificacao,
                    f.data_frete,
                    f.valor_frete,
                    f.status,
                    f.observacoes

                ORDER BY f.id_frete ASC";

            $inicio = $dataValidada->format('Y-m-d') . ' 00:00:00';
            $fim = $dataValidada->modify('+1 day')->format('Y-m-d') . ' 00:00:00';

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':inicio' => $inicio,
                ':fim' => $fim
            ]);

            $fretes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($fretes)) {
                http_response_code(404);
                header('Content-Type: application/json; charset=utf-8');

                echo json_encode([
                    'mensagem' => 'Não existem fretes cadastrados nesta data.'
                ]);

                return;
            }

            // Prepara o download do CSV
            $nomeArquivo = 'relatorio-fretes-' . $data . '.csv';

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');

            // BOM para compatibilidade com Excel
            echo "\xEF\xBB\xBF";

            $arquivo = fopen('php://output', 'w');

            // Cabeçalho do relatório
            fputcsv($arquivo, [
                'ID',
                'Transportador',
                'Origem',
                'Destino',
                'Produtos',
                'Data',
                'Valor do frete',
                'Status',
                'Observações'
            ], ';');

            // Dados dos fretes
            foreach ($fretes as $frete) {

                fputcsv($arquivo, [
                    $frete['id_frete'],
                    $frete['transportador'],
                    $frete['origem'],
                    $frete['destino'],
                    $frete['produtos'] ?? '',
                    date('d/m/Y', strtotime($frete['data_frete'])),
                    number_format((float) $frete['valor_frete'], 2, ',', '.'),
                    $frete['status'],
                    $frete['observacoes']
                ], ';');
            }

            fclose($arquivo);
            exit;
        } catch (\Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode([
                'mensagem' => 'Ocorreu um erro ao gerar o relatório.'
            ]);
        }
    }
}
