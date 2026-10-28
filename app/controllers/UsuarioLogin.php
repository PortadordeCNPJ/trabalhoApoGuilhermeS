
<?php

use app\models\Connection;
use app\models\Usuario;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = md5($_POST['senha']) ?? '';

    if ($email === '' || $senha === '') {
        $_SESSION['erro_login'] = 'Informe o e-mail e a senha.';
        header('Location: index.php?pagina=login');
        exit;
    }

    try {
        $pdo = Connection::connect();

        $usuario = Usuario::buscarPorEmail($pdo, $email);

        if ($senha === $usuario['senha'] && $email === $usuario['email']) {
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['email_usuario'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            if ($usuario['tipo_usuario'] === 'admin') {
                echo "<script>alert('Login efetuado com sucesso');</script>";
                header('Location: index.php?pagina=admin');
            } else {
                echo "<script>alert('Login efetuado com sucesso');</script>";
                header('Location: index.php?pagina=home');
            }
        } else {

            echo "<script>alert('Usuario ou senha não encontros');</script>";
            header('Location: index.php?pagina=login');
            //echo "<script>location.href='../app/views/login.';<script>";
        }
    } catch (\PDOException $e) {
        error_log($e->getMessage());

        $_SESSION['erro_login'] =
            'Não foi possível realizar o login agora.';

        header('Location: index.php?pagina=login');
        exit;
    }
}
