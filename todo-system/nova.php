<?php
// nova.php — Cadastro de nova tarefa
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteção de sessão
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($titulo === '') {
        $erro = 'O título da tarefa é obrigatório.';
    } else {
        // Inserção com prepared statement
        $stmt = $pdo->prepare(
            'INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)'
        );
        $stmt->execute([$titulo, $descricao, $_SESSION['usuario_id']]);
        header('Location: index.php');
        exit;
    }
}
?>
<?php include 'layout.php'; ?>

<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php" class="text-decoration-none text-primary">
                                <i class="bi bi-house me-1"></i>Tarefas
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Nova Tarefa</li>
                    </ol>
                </nav>

                <div class="card card-taskflow">
                    <div class="card-header">
                        <i class="bi bi-plus-circle me-2"></i>Nova Tarefa
                    </div>
                    <div class="card-body p-4">

                        <?php if ($erro !== ''): ?>
                        <div class="alert alert-taskflow d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span><?= htmlspecialchars($erro) ?></span>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="nova.php" novalidate>

                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-semibold">
                                    <i class="bi bi-type me-1 text-primary"></i>
                                    Título <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="titulo"
                                    name="titulo"
                                    class="form-control"
                                    placeholder="Ex.: Estudar para a prova"
                                    value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                                    required
                                    autofocus
                                >
                                <div class="form-text">Campo obrigatório.</div>
                            </div>

                            <div class="mb-4">
                                <label for="descricao" class="form-label fw-semibold">
                                    <i class="bi bi-card-text me-1 text-primary"></i>Descrição
                                </label>
                                <textarea
                                    id="descricao"
                                    name="descricao"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Descreva os detalhes da tarefa (opcional)..."
                                ><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-brand flex-grow-1">
                                    <i class="bi bi-floppy me-2"></i>Salvar Tarefa
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'layout_footer.php'; ?>
