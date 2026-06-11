<?php
session_start();
require_once 'conexao.php';

// ─── VERIFICA SE É POST ───────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php');
    exit;
}

// ─── CAPTURA OS DADOS DO FORMULÁRIO ──────────────────────
$usuario = trim($_POST['usuario'] ?? '');
$senha   = $_POST['senha'] ?? '';

// ─── VALIDA SE OS CAMPOS ESTÃO PREENCHIDOS ────────────────
if(empty($usuario) || empty($senha)){
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

// ─── SALVA OS DADOS NA SESSÃO ─────────────────────────────
$_SESSION['id'] = (int) $user['id'];
$_SESSION['nome'] = $user['nome'];
$_SESSION['email'] = $usuario;
$_SESSION['nivel'] = $user['nivel'];
$_SESSION['id_empresa'] = (int) $user['empresa'];

header('Location: painel');
exit;
?>