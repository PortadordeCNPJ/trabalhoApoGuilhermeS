<?php

namespace app\controllers;

use app\models\Connection;
use app\models\Usuario;
use PDOException;

class UsuarioController
{
    public static function cadastrarCliente(): void
    {
        // Verifica se o formulário foi enviado por POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=criarUsuarios');
            exit;
        }

        // Recebe os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = md5($_POST['senha']) ?? '';

        // Validação dos campos
        $erros = [];

        if (empty($nome)) {
            $erros[] = 'O nome é obrigatório.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Informe um e-mail válido.';
        }

        if (strlen($senha) < 8) {
            $erros[] = 'A senha deve possuir pelo menos 8 caracteres.';
        }

        // Se houver erros, retorna ao formulário
        if (!empty($erros)) {
            $_SESSION['erros_usuario'] = $erros;

            header('Location: index.php?pagina=criarUsuarios');
            exit;
        }

        try {

            // Conecta ao banco
            $pdo = Connection::connect();

            // Insere o usuário
            Usuario::inserir(
                $pdo,
                $nome,
                $email,
                $senha
            );

            $_SESSION['sucesso_usuario'] =
                'Usuário cadastrado com sucesso!';

        } catch (PDOException $e) {

            error_log($e->getMessage());

            // Verifica se o erro foi de e-mail duplicado
            if ($e->getCode() === '23000') {
                $_SESSION['erros_usuario'] = [
                    'Este e-mail já está cadastrado no sistema.'
                ];
            } else {
                $_SESSION['erros_usuario'] = [
                    'Não foi possível cadastrar o usuário.'
                ];
            }
        }

        header('Location: index.php?pagina=criarUsuarios');
        exit;
    }
}
