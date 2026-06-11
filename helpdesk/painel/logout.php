<?php
/**
 * Logout - encerra a sessão e redireciona para a tela de login
 */

session_start();

// Remove todas as variáveis da sessão
$_SESSION = [];

// Destrói o cookie de sessão (se existir)
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destrói a sessão
session_destroy();

header('Location: ../index.php');
exit;
