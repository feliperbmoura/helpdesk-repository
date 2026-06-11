<?php
/**
 * Painel do sistema - área logada
 * Verificação de sessão e exibição dos dados do usuário
 */

session_start();

// Verificação de sessão: redireciona para login se não autenticado
if (empty($_SESSION['id']) || !isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}

// Recupera dados do usuário da sessão (já sanitizados no login)
$usuario_id = (int) $_SESSION['id'];
$usuario_nome = htmlspecialchars($_SESSION['nome'] ?? '', ENT_QUOTES, 'UTF-8');
$usuario_email = htmlspecialchars($_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8');
$usuario_nivel = htmlspecialchars($_SESSION['nivel'] ?? '', ENT_QUOTES, 'UTF-8');
$usuario_empresa = (int) ($_SESSION['id_empresa'] ?? 0);

require_once __DIR__ . '/../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - <?php echo htmlspecialchars($nome_sistema); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --cor-primaria: <?php echo htmlspecialchars($cor_primaria); ?>; --cor-secundaria: <?php echo htmlspecialchars($cor_secundaria); ?>; }
        .painel-header { background: linear-gradient(135deg, var(--cor-primaria) 0%, var(--cor-secundaria) 100%); color: white; padding: 1rem 0; }
        .btn-logout { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.5); color: white; }
        .btn-logout:hover { background: rgba(255,255,255,0.3); color: white; border-color: white; }
        .card-dados { border-left: 4px solid var(--cor-primaria); }
    </style>
</head>
<body>
    <header class="painel-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0"><i class="bi bi-speedometer2"></i> <?php echo $nome_sistema; ?></h1>
                <a href="logout.php" class="btn btn-sm btn-logout"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
    </header>

    <main class="container py-4">
        <h2 class="h4 mb-4">Bem-vindo ao painel</h2>

        <div class="card card-dados shadow-sm mb-4">
            <div class="card-header bg-light">
                <i class="bi bi-person-circle"></i> Dados do usuário
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9"><?php echo $usuario_id; ?></dd>

                    <dt class="col-sm-3">Nome</dt>
                    <dd class="col-sm-9"><?php echo $usuario_nome; ?></dd>

                    <dt class="col-sm-3">E-mail</dt>
                    <dd class="col-sm-9"><?php echo $usuario_email; ?></dd>

                    <dt class="col-sm-3">Nível</dt>
                    <dd class="col-sm-9"><?php echo $usuario_nivel; ?></dd>

                    <dt class="col-sm-3">Empresa (ID)</dt>
                    <dd class="col-sm-9"><?php echo $usuario_empresa; ?></dd>
                </dl>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
