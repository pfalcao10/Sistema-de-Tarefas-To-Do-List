<?php
// layout.php — Arquivo de layout compartilhado
// FRAMEWORK ESCOLHIDO: Bootstrap 5
// Importado via CDN: https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css

// Este arquivo é incluído por todas as páginas do sistema.
// Uso: include 'layout.php'; (antes do conteúdo da página)
//      include_once 'layout_footer.php'; (após o conteúdo)

// Garante que a sessão esteja iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paginaAtual = basename($_SERVER['PHP_SELF']);
$usuarioLogado = $_SESSION['usuario'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow — Gerenciador de Tarefas</title>

    <!-- Bootstrap 5 CSS — Framework escolhido para TODAS as páginas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-secondary: #7c3aed;
            --brand-accent: #06b6d4;
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Sora', sans-serif;
            background-color: #f0f4ff;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-taskflow {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
            box-shadow: 0 4px 20px rgba(79,70,229,.35);
            padding: .9rem 0;
        }

        .navbar-taskflow .navbar-brand {
            font-weight: 700;
            font-size: 1.35rem;
            color: #fff !important;
            letter-spacing: -.5px;
        }

        .navbar-taskflow .nav-user {
            color: rgba(255,255,255,.85);
            font-size: .9rem;
        }

        .navbar-taskflow .btn-logout {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff;
            font-size: .85rem;
            border-radius: 20px;
            padding: .35rem .9rem;
            transition: background .2s;
        }

        .navbar-taskflow .btn-logout:hover {
            background: rgba(255,255,255,.28);
            color: #fff;
        }

        /* ── Cards / Wrappers ── */
        .page-wrapper {
            padding: 2rem 0 3rem;
        }

        .card-taskflow {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(79,70,229,.08);
            overflow: hidden;
        }

        .card-taskflow .card-header {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            color: #fff;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border: none;
        }

        /* ── Tabela ── */
        .table-taskflow thead th {
            background-color: #eef2ff;
            color: var(--brand-primary);
            font-weight: 600;
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 2px solid #c7d2fe;
            padding: .9rem 1rem;
        }

        .table-taskflow tbody tr {
            transition: background .15s;
        }

        .table-taskflow tbody tr:hover {
            background-color: #f5f3ff;
        }

        .table-taskflow tbody td {
            padding: .8rem 1rem;
            vertical-align: middle;
            border-color: #e2e8f0;
            font-size: .92rem;
        }

        /* ── Badges de status ── */
        .badge-pendente {
            background-color: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
            font-size: .78rem;
            padding: .35em .7em;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-concluida {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            font-size: .78rem;
            padding: .35em .7em;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── Botões de ação ── */
        .btn-action {
            font-size: .78rem;
            padding: .3rem .65rem;
            border-radius: 8px;
        }

        /* ── Formulários ── */
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 .25rem rgba(79,70,229,.18);
        }

        .btn-primary-brand {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .6rem 1.5rem;
            border-radius: 10px;
            transition: opacity .2s, transform .15s;
        }

        .btn-primary-brand:hover {
            opacity: .92;
            transform: translateY(-1px);
            color: #fff;
        }

        /* ── Alert de erro ── */
        .alert-taskflow {
            border-left: 4px solid #ef4444;
            background: #fef2f2;
            color: #991b1b;
            border-radius: 10px;
        }

        /* Login page */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #06b6d4 100%);
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
        }

        .login-card .card-header {
            background: transparent;
            border: none;
            text-align: center;
            padding: 2rem 2rem 1rem;
        }

        .login-logo {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto .75rem;
            font-size: 1.6rem;
            color: #fff;
        }
    </style>
</head>
<body>

<?php if ($paginaAtual !== 'login.php'): ?>
<!-- ── Navbar (exibida em todas as páginas autenticadas) ── -->
<nav class="navbar navbar-taskflow">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-check2-square me-2"></i>TaskFlow
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="nav-user d-none d-sm-inline">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($usuarioLogado) ?>
            </span>
            <a href="logout.php" class="btn btn-logout">
                <i class="bi bi-box-arrow-right me-1"></i>Sair
            </a>
        </div>
    </div>
</nav>
<?php endif; ?>
