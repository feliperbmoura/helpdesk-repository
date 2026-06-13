<?php
session_start();
require_once 'conexao.php';




// ✅ REMOVIDA a linha que gravava flash no topo

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Proteção CSRF
$token_post   = $_POST['csrf_token'] ?? '';
$token_sessao = $_SESSION['csrf_token_login'] ?? '';

if (empty($token_post) || !hash_equals((string)$token_sessao, (string)$token_post)) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'csrf_invalido'];
    header('Location: index.php');
    exit;
}

$usuario = trim((string)($_POST['usuario'] ?? ''));
$senha   = (string)($_POST['senha'] ?? '');

if (!filter_var($usuario, FILTER_VALIDATE_EMAIL) || strlen($usuario) > 100) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'csrf_invalido'];
    header('Location: index.php');
    exit;
}

if (strlen($senha) > 256 || $senha === '') {
    // ✅ Dados inválidos → flash correto
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'login_invalido'];
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nome, senha, nivel, ativo, empresa
    FROM usuarios
    WHERE email = :usuario
    LIMIT 1
");
$stmt->execute([':usuario' => $usuario]);
$user = $stmt->fetch();

// ✅ Email não encontrado → flash correto
if (!$user) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'login_invalido'];
    header('Location: index.php');
    exit;
}

// ✅ Usuário inativo → flash correto
if (strtoupper($user['ativo']) !== 'SIM') {
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'usuario_inativo'];
    header('Location: index.php');
    exit;
}

// ✅ Senha errada → flash correto
if (!password_verify($senha, $user['senha'])) {
    $_SESSION['flash'] = ['tipo' => 'erro', 'codigo' => 'login_invalido'];
    header('Location: index.php');
    exit;
}

session_regenerate_id(true);

$_SESSION['id']         = (int)$user['id'];
$_SESSION['nome']       = $user['nome'];
$_SESSION['email']      = $usuario;
$_SESSION['nivel']      = $user['nivel'];
$_SESSION['id_empresa'] = (int)$user['empresa'];

unset($_SESSION['csrf_token_login']);

header('Location: painel/');
exit;
?>