<?php

namespace app\models;

use PDO;

class Produto
{
    public static function cadastrar(PDO $pdo, array $dados): bool
    {
        $sql = "INSERT INTO produtos
                    (nome, descricao, peso, valor, quantidade_estoque)
                VALUES
                    (:nome, :descricao, :peso, :valor, :quantidade_estoque)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':descricao' => $dados['descricao'],
            ':peso' => $dados['peso'],
            ':valor' => $dados['valor'],
            ':quantidade_estoque' => $dados['quantidade_estoque']
        ]);
    }

    public static function listar(PDO $pdo): array
    {
        $sql = "SELECT id_produto, nome, descricao, peso,
                       valor, quantidade_estoque, criado_em
                FROM produtos
                ORDER BY id_produto DESC";

        return $pdo->query($sql)->fetchAll();
    }
}
