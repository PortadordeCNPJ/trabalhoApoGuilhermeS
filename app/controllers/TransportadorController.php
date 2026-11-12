<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Transportador;
use PDOException;

class TransportadorController
{
    public static function cadastrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=transportador');
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $documento = preg_replace('/\D/', '', $_POST['documento'] ?? '');
        $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
        $tipoVeiculo = trim($_POST['tipo_veiculo'] ?? '');
        $placa = strtoupper(trim($_POST['placa'] ?? ''));
        $ativo = isset($_POST['ativo']) ? 1 : 0;

        $erros = [];

        if ($nome === '') {
            $erros[] = 'Informe o nome do transportador.';
        }

        if (!in_array(strlen($documento), [11, 14], true)) {
            $erros[] = 'O documento deve possuir 11 dígitos (CPF) ou 14 dígitos (CNPJ).';
        }

        if (!in_array(strlen($telefone), [10, 11], true)) {
            $erros[] = 'Informe um telefone válido com DDD.';
        }

        $tiposPermitidos = [
            'Moto',
            'Carro',
            'Van',
            'Caminhão',
            'Carreta',
            'Outro'
        ];

        if (!in_array($tipoVeiculo, $tiposPermitidos, true)) {
            $erros[] = 'Selecione um tipo de veículo válido.';
        }

        // Aceita placas antigas e padrão Mercosul.
        if (!preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', $placa)) {
            $erros[] = 'Informe uma placa válida.';
        }

        if (!empty($erros)) {
            $_SESSION['erros_transportador'] = $erros;
            header('Location: index.php?pagina=transportador');
            exit;
        }

        try {
            $pdo = Connection::connect();

            $dados = [
                'nome' => $nome,
                'documento' => $documento,
                'telefone' => $telefone,
                'tipo_veiculo' => $tipoVeiculo,
                'placa' => $placa,
                'ativo' => $ativo
            ];

            Transportador::cadastrar($pdo, $dados);

            $_SESSION['sucesso_transportador'] =
                'Transportador cadastrado com sucesso!';

        } catch (PDOException $e) {
            $_SESSION['erros_transportador'] = [
                'Não foi possível cadastrar o transportador. Verifique os dados e tente novamente.'
            ];

            // Durante o desenvolvimento, consulte o log do PHP
            // para identificar o erro técnico.
            error_log($e->getMessage());
        }

        header('Location: index.php?pagina=transportador');
        exit;
    }
}
