<?php

namespace app\models;

use PDO;

class Transportador
{
    public static function cadastrar(PDO $pdo, array $dados): bool
    {
        $sql = "INSERT INTO transportadores
                (nome, documento, telefone, tipo_veiculo, placa, ativo)
                VALUES
                (:nome, :documento, :telefone, :tipo_veiculo, :placa, :ativo)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':documento' => $dados['documento'],
            ':telefone' => $dados['telefone'],
            ':tipo_veiculo' => $dados['tipo_veiculo'],
            ':placa' => $dados['placa'],
            ':ativo' => $dados['ativo']
        ]);
    }
}
