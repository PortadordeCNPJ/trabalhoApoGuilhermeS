<?php

namespace app\models;

use PDO;

class Endereco
{
    public static function cadastrar(PDO $pdo, array $dados): bool
    {
        $sql = "INSERT INTO enderecos (
                    identificacao,
                    logradouro,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado,
                    cep
                ) VALUES (
                    :identificacao,
                    :logradouro,
                    :numero,
                    :complemento,
                    :bairro,
                    :cidade,
                    :estado,
                    :cep
                )";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':identificacao' => $dados['identificacao'],
            ':logradouro' => $dados['logradouro'],
            ':numero' => $dados['numero'],
            ':complemento' => $dados['complemento'],
            ':bairro' => $dados['bairro'],
            ':cidade' => $dados['cidade'],
            ':estado' => $dados['estado'],
            ':cep' => $dados['cep']
        ]);
    }
}
