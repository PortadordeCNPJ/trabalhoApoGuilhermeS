
<?php

use app\models\Connection;
use app\models\Usuario;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        exit('Preencha todos os campos.');
    }

    try {
        $pdo = Connection::connect();

        Usuario::inserir($pdo, $nome, $email, $senha);

        echo 'Usuário cadastrado com sucesso!';
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        echo 'Não foi possível cadastrar o usuário.';
    }
}
