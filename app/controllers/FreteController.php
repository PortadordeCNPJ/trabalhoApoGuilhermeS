<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Frete;
use PDOException;

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

                if (!$idProduto || $idProduto <= 0 ||
                    !$quantidade || $quantidade <= 0) {
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
}
