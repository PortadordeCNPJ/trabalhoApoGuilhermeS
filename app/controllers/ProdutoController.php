<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Produto;

class ProdutoController
{
    public static function index(): void
    {
        $pdo = Connection::connect();
        $produtos = Produto::listar($pdo);

        require dirname(__DIR__) . '/views/admin/produtos.php';
    }

    public static function cadastrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=cadastro_produtos');
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $peso = $_POST['peso'] ?? '';
        $valor = $_POST['valor'] ?? '';
        $quantidade = $_POST['quantidade_estoque'] ?? '';

        $erros = [];

        if ($nome === '') {
            $erros[] = 'Informe o nome do produto.';
        }

        if (!is_numeric($peso) || (float) $peso <= 0) {
            $erros[] = 'O peso deve ser maior que zero.';
        }

        if (!is_numeric($valor) || (float) $valor < 0) {
            $erros[] = 'Informe um valor válido para o produto.';
        }

        $quantidadeValida = filter_var(
            $quantidade,
            FILTER_VALIDATE_INT
        );

        if ($quantidadeValida === false || $quantidadeValida < 0) {
            $erros[] = 'A quantidade deve ser um inteiro maior ou igual a zero.';
        }

        if ($erros) {
            $_SESSION['erros_produto'] = $erros;
            $_SESSION['dados_produto'] = [
                'nome' => $nome,
                'descricao' => $descricao,
                'peso' => $peso,
                'valor' => $valor,
                'quantidade_estoque' => $quantidade
            ];

            header('Location: index.php?pagina=cadastro_produtos');
            exit;
        }

        try {
            $pdo = Connection::connect();

            Produto::cadastrar($pdo, [
                'nome' => $nome,
                'descricao' => $descricao !== '' ? $descricao : null,
                'peso' => $peso,
                'valor' => $valor,
                'quantidade_estoque' => $quantidadeValida
            ]);

            $_SESSION['sucesso_produto'] =
                'Produto cadastrado com sucesso!';

        } catch (\PDOException $e) {
            error_log($e->getMessage());

            $_SESSION['erros_produto'] = [
                'Não foi possível cadastrar o produto. Verifique os dados e tente novamente.'
            ];
        }

        header('Location: index.php?pagina=cadastro_produtos');
        exit;
    }
}
