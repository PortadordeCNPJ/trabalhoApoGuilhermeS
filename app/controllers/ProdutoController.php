<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Produto;

class ProdutoController
{
    // Apenas busca os produtos e devolve os dados.
    public static function index(): array
    {
        $pdo = Connection::connect();

        return Produto::listar($pdo);
    }

    // Processa o formulário de cadastro.
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
            $erros[] = 'Informe um peso válido.';
        }

        if (!is_numeric($valor) || (float) $valor < 0) {
            $erros[] = 'Informe um valor válido.';
        }

        $quantidadeValida = filter_var(
            $quantidade,
            FILTER_VALIDATE_INT
        );

        if ($quantidadeValida === false || $quantidadeValida < 0) {
            $erros[] = 'Informe uma quantidade válida.';
        }

        if (!empty($erros)) {
            $_SESSION['erros_produto'] = $erros;

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
                'Não foi possível cadastrar o produto.'
            ];
        }

        header('Location: index.php?pagina=cadastro_produtos');
        exit;
    }
}
