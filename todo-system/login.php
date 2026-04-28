<?php
// login.php — Autenticação do usuário via MD5 + sessão
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se já estiver logado, redireciona direto
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha']   ?? '');

    if ($usuario === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        // Verifica usuário e senha (MD5) no banco de dados
        $stmt = $pdo->prepare('SELECT id, usuario FROM usuarios WHERE usuario = ? AND senha = MD5(?)');
        $stmt->execute([$usuario, $senha]);
        $user = $stmt->fetch();

        if ($user) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario']    = $user['usuario'];
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos.';
        }
    }
}
?>
<?php include 'layout.php'; ?>

<div class="login-wrapper">
    <div class="login-card card">
        <div class="card-header">
            <div class="login-logo">
                <i class="bi bi-check2-square"></i>
            </div>
            <h4 class="fw-700 mb-1" style="font-weight:700;">TaskFlow</h4>
            <p class="text-muted mb-0" style="font-size:.9rem;">Gerenciador de Tarefas</p>
        </div>

        <div class="card-body px-4 pb-4">

            <?php if ($erro !== ''): ?>
            <div class="alert alert-taskflow d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span><?= htmlspecialchars($erro) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="login.php" novalidate>
                <div class="mb-3">
                    <label for="usuario" class="form-label fw-semibold" style="font-size:.9rem;">
                        <i class="bi bi-person me-1 text-primary"></i>Usuário
                    </label>
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        class="form-control"
                        placeholder="Digite seu usuário"
                        value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label fw-semibold" style="font-size:.9rem;">
                        <i class="bi bi-lock me-1 text-primary"></i>Senha
                    </label>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary-brand w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </button>
            </form>

            <p class="text-center text-muted mt-3 mb-0" style="font-size:.78rem;">
                Usuário de teste: <strong>admin</strong> / <strong>123456</strong>
            </p>
        </div>
    </div>
</div>

<?php include 'layout_footer.php'; ?>
