
<?php

use app\models\Connection;
use app\models\Usuario;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $_SESSION['erro_login'] = 'Informe o e-mail e a senha.';
        header('Location: index.php?pagina=login');
        exit;
    }

    try {
        $pdo = Connection::connect();

        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['email_usuario'] = $usuario['email'];

            header('Location: index.php?pagina=home');
            exit;
        }

        $_SESSION['erro_login'] = 'E-mail ou senha incorretos.';
        header('Location: index.php?pagina=login');
        exit;

    } catch (\PDOException $e) {
        error_log($e->getMessage());

        $_SESSION['erro_login'] =
            'Não foi possível realizar o login agora.';

        header('Location: index.php?pagina=login');
        exit;
    }
}
