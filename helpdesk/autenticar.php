<?php
session_start();
require_once 'conexao.php';

// ─── VERIFICA SE É POST ───────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php');
    exit;
}

// Proteção CSRF: valida token do Formulario
$token_post = $_POST['csrf_token'] ?? '';
$token_sessao = $_SESSION['csrf_token_login'] ?? '';
if(empty($token_post) || !hash_equals((string) $token_sessao, (string) $token_post)){
    header('Location: index.php?erro=1');
    exit();
}

// ─── CAPTURA OS DADOS DO FORMULÁRIO ──────────────────────
$usuario = trim((string) ($_POST['usuario'] ?? ''));
$senha   = (string) ($_POST['senha'] ?? '');

// ─── VALIDA SE OS CAMPOS ESTÃO PREENCHIDOS ────────────────
if(!filter_var($usuario, FILTER_VALIDATE_EMAIL) || strlen($usuario) > 100){
    header('Location: index.php?erro=1');
    exit;
}

// Limite de tamanho na senha (bcrypt usa até 72 bytes; evita payload gigante)
if(strlen($senha) > 256 || $senha === ''){
    header('Location: index.php?erro=1');
    exit;
}

// ─── BUSCA O USUÁRIO NO BANCO PELO EMAIL ──────────────────
$stmt = $pdo->prepare("
    SELECT id, nome, senha, nivel, ativo, empresa
    FROM usuarios
    WHERE email = :usuario
    LIMIT 1
");

$stmt->execute([':usuario' => $usuario]);
$user = $stmt->fetch();                   

// ─── VERIFICA SE O EMAIL EXISTE ───────────────────────────
if(!$user){
    header('Location: index.php?erro=1'); 
    exit;
}

// ─── VERIFICA SE O USUÁRIO ESTÁ ATIVO ────────────────────
if(strtoupper($user['ativo']) !== 'SIM'){
    header('Location: index.php?erro=2');
    exit;
}

// ─── VERIFICA A SENHA ─────────────────────────────────────
if(!password_verify($senha, $user['senha'])){
    header('Location: index.php?erro=3');
    exit;
}

session_regenerate_id(true);

// ─── SALVA OS DADOS NA SESSÃO ─────────────────────────────
$_SESSION['id'] = (int) $user['id'];
$_SESSION['nome'] = $user['nome'];
$_SESSION['email'] = $usuario;
$_SESSION['nivel'] = $user['nivel'];
$_SESSION['id_empresa'] = (int) $user['empresa'];

unset($_SESSION['csrf_token_login']);

header('Location: painel');
exit;
?>