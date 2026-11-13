<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Endereco;
use PDOException;

class EnderecoController
{
    public static function cadastrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=endereco');
            exit;
        }

        // Recebendo os dados do formulário
        $identificacao = trim($_POST['identificacao'] ?? '');
        $logradouro = trim($_POST['logradouro'] ?? '');
        $numero = trim($_POST['numero'] ?? '');
        $complemento = trim($_POST['complemento'] ?? '');
        $bairro = trim($_POST['bairro'] ?? '');
        $cidade = trim($_POST['cidade'] ?? '');
        $estado = strtoupper(trim($_POST['estado'] ?? ''));

        // Mantém somente os números do CEP
        $cep = preg_replace('/\D/', '', $_POST['cep'] ?? '');

        $erros = [];

        // Validações
        if ($identificacao === '') {
            $erros[] = 'Informe uma identificação para o endereço.';
        }

        if ($logradouro === '') {
            $erros[] = 'Informe o logradouro.';
        }

        if ($numero === '') {
            $erros[] = 'Informe o número do endereço.';
        }

        if ($bairro === '') {
            $erros[] = 'Informe o bairro.';
        }

        if ($cidade === '') {
            $erros[] = 'Informe a cidade.';
        }

        if (!preg_match('/^[A-Z]{2}$/', $estado)) {
            $erros[] = 'Informe uma UF válida com duas letras.';
        }

        if (strlen($cep) !== 8) {
            $erros[] = 'O CEP deve possuir exatamente 8 números.';
        }

        // Se houver erros, retorna ao formulário
        if (!empty($erros)) {
            $_SESSION['erros_endereco'] = $erros;

            header('Location: index.php?pagina=cadastro_enderecos');
            exit;
        }

        try {
            $pdo = Connection::connect();

            $dados = [
                'identificacao' => $identificacao,
                'logradouro' => $logradouro,
                'numero' => $numero,
                'complemento' => $complemento,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'cep' => $cep
            ];

            Endereco::cadastrar($pdo, $dados);

            $_SESSION['sucesso_endereco'] =
                'Endereço cadastrado com sucesso!';

        } catch (PDOException $e) {

            $_SESSION['erros_endereco'] = [
                'Não foi possível cadastrar o endereço. Tente novamente.'
            ];

            error_log($e->getMessage());
        }

        header('Location: index.php?pagina=endereco');
        exit;
    }
}
