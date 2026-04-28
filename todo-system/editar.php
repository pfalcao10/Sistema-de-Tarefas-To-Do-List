<?php
// editar.php — Edição de tarefa existente
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteção de sessão
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];
$id         = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Busca a tarefa (garantindo que pertence ao usuário logado)
$stmt = $pdo->prepare(
    'SELECT id, titulo, descricao, status FROM tarefas WHERE id = ? AND usuario_id = ?'
);
$stmt->execute([$id, $usuario_id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status    = $_POST['status'] ?? 'pendente';

    // Valida status
    if (!in_array($status, ['pendente', 'concluida'], true)) {
        $status = 'pendente';
    }

    if ($titulo === '') {
        $erro = 'O título da tarefa é obrigatório.';
    } else {
        $stmt = $pdo->prepare(
            'UPDATE tarefas SET titulo = ?, descricao = ?, status = ?
             WHERE id = ? AND usuario_id = ?'
        );
        $stmt->execute([$titulo, $descricao, $status, $id, $usuario_id]);
        header('Location: index.php');
        exit;
    }

    // Mantém valores do POST em caso de erro
    $tarefa['titulo']    = $titulo;
    $tarefa['descricao'] = $descricao;
    $tarefa['status']    = $status;
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
                        <li class="breadcrumb-item active">Editar Tarefa</li>
                    </ol>
                </nav>

                <div class="card card-taskflow">
                    <div class="card-header">
                        <i class="bi bi-pencil-square me-2"></i>Editar Tarefa
                        <span class="badge bg-white text-primary ms-2" style="font-size:.75rem;">#<?= $id ?></span>
                    </div>
                    <div class="card-body p-4">

                        <?php if ($erro !== ''): ?>
                        <div class="alert alert-taskflow d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span><?= htmlspecialchars($erro) ?></span>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="editar.php?id=<?= $id ?>" novalidate>

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
                                    value="<?= htmlspecialchars($tarefa['titulo']) ?>"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label fw-semibold">
                                    <i class="bi bi-card-text me-1 text-primary"></i>Descrição
                                </label>
                                <textarea
                                    id="descricao"
                                    name="descricao"
                                    class="form-control"
                                    rows="4"
                                ><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="bi bi-flag me-1 text-primary"></i>Status
                                </label>
                                <select id="status" name="status" class="form-select">
                                    <option value="pendente"
                                        <?= $tarefa['status'] === 'pendente'  ? 'selected' : '' ?>>
                                        ⏳ Pendente
                                    </option>
                                    <option value="concluida"
                                        <?= $tarefa['status'] === 'concluida' ? 'selected' : '' ?>>
                                        ✅ Concluída
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-brand flex-grow-1">
                                    <i class="bi bi-floppy me-2"></i>Salvar Alterações
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
