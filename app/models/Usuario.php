<?php

namespace app\models;

use PDO;

class Usuario
{
    public static function inserir(
        PDO $pdo,
        string $nome,
        string $email,
        string $senha,
        string $tipo_usuario
    ): bool {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo_usuario)
                VALUES (:nome, :email, :senha, :tipo_usuario)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => md5($senha),
            ':tipo_usuario' => $tipo_usuario
        ]);
    }

    public static function buscarPorEmail(PDO $pdo, string $email): array|false

    {
        $sql = "SELECT id_usuario, nome, email, senha, tipo_usuario
            FROM usuarios
            WHERE email =:email
            LIMIT 1";

        $smt = $pdo->prepare($sql);
        $smt->execute([
            'email' => $email
        ]);

        return $smt->fetch();
    }


    public static function listar(PDO $pdo): array
    {
        $sql = "SELECT
                id_usuario,
                nome,
                email,
                tipo_usuario,
                criado_em
            FROM usuarios
            ORDER BY id_usuario DESC";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
