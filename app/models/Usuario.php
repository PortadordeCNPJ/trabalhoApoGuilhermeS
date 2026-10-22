<?php

namespace app\models;

use PDO;

class Usuario
{
    public static function inserir(
        PDO $pdo,
        string $nome,
        string $email,
        string $senha
    ): bool {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo_usuario)
                VALUES (:nome, :email, :senha, :tipo_usuario)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => password_hash($senha, PASSWORD_DEFAULT),
            ':tipo_usuario' => 'usuario'
        ]);
    }
}