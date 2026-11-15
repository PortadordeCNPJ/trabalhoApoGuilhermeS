<?php

namespace app\controllers;

class LogoutController
{
    public static function sair(): void
    {
        // Garante que a sessão esteja iniciada.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Remove todas as informações da sessão.
        $_SESSION = [];

        // Remove o cookie da sessão, se estiver utilizando cookies.
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Encerra a sessão.
        session_destroy();

        // Redireciona para o login.
        header('Location: index.php?pagina=login');
        exit;
    }
}
