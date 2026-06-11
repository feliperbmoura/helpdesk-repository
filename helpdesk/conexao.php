<?php

$modo_teste = 'Sim'; // essa variável serve para limitar o usuario a fazer testes no sistema

date_default_timezone_set('America/Sao_Paulo');

// ─── CONEXÃO ─────────────────────────────────────────────
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco_de_dados = 'helpdesk';

try {
    $pdo = new PDO(
        "mysql:host=$servidor;dbname=$banco_de_dados;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}

// ─── SENHA PADRÃO ────────────────────────────────────

$senha_padrao = '123';

// ─── VARIÁVEIS PADRÃO ────────────────────────────────────
$nome_sistema  = 'Sistema HelpDesk';
$telefone_sistema = '(14) 99131-4963';
$email_sistema = 'felipemoura10k@gmail.com';
$cor_primaria = '#667eea';
$cor_secundaria = '#764ba2';
$id_empresa = 0;

// ─── CARREGAMENTO DA CONFIG ──────────────────────────────
$stmt = $pdo->query("SELECT * FROM config WHERE empresa = 0 LIMIT 1");
$config = $stmt->fetch();

if (!$config) {
    $stmt = $pdo->prepare("
        INSERT INTO config (nome_sistema, telefone_sistema, email_sistema, cor_primaria, cor_secundaria, empresa)
        VALUES (:nome_sistema, :telefone_sistema, :email_sistema, :cor_primaria, :cor_secundaria, :id_empresa)
    ");

    $stmt->execute([
        ':nome_sistema'  => $nome_sistema,
        ':telefone_sistema' => $telefone_sistema,
        ':email_sistema' => $email_sistema,
        ':cor_primaria'  => $cor_primaria,
        ':cor_secundaria' => $cor_secundaria,
        ':id_empresa' => $id_empresa   
    ]);

    $stmt   = $pdo->query("SELECT * FROM config WHERE empresa = 0 LIMIT 1");
    $config = $stmt->fetch();
}

// ─── SOBRESCREVE VARIÁVEIS COM DADOS DO BANCO ───────────
if ($config) { 
    $nome_sistema = $config['nome_sistema'] ?? $nome_sistema;
    $telefone_sistema = $config['telefone_sistema'] ?? $telefone_sistema;
    $email_sistema = $config['email_sistema'] ?? $email_sistema;
    $cor_primaria = $config['cor_primaria'] ?? $cor_primaria;
    $cor_secundaria = $config['cor_secundaria'] ?? $cor_secundaria;
    $id_empresa = (int) ($config['empresa'] ?? $id_empresa);
}
?>