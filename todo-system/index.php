<?php
// index.php
// FRAMEWORK: Bootstrap 5 — importado em layout.php
// via CDN: https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css

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

// Busca tarefas do usuário logado (mais recentes primeiro)
$stmt = $pdo->prepare(
    'SELECT id, titulo, descricao, status, criado_em
     FROM tarefas
     WHERE usuario_id = ?
     ORDER BY criado_em DESC'
);
$stmt->execute([$usuario_id]);
$tarefas = $stmt->fetchAll();

$total      = count($tarefas);
$pendentes  = count(array_filter($tarefas, fn($t) => $t['status'] === 'pendente'));
$concluidas = $total - $pendentes;
?>
<?php include 'layout.php'; ?>

<div class="page-wrapper">
    <div class="container">

        <!-- ── Cabeçalho da página ── -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
            <div>
                <h2 class="fw-700 mb-0" style="font-weight:700;">Minhas Tarefas</h2>
                <p class="text-muted mb-0" style="font-size:.9rem;">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong> — gerencie suas tarefas abaixo.
                </p>
            </div>
            <a href="nova.php" class="btn btn-primary-brand">
                <i class="bi bi-plus-lg me-1"></i> Nova Tarefa
            </a>
        </div>

        <!-- ── Cards de resumo ── -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="card card-taskflow text-center py-3">
                    <div class="fs-3 fw-bold text-primary"><?= $total ?></div>
                    <div class="text-muted" style="font-size:.82rem;">Total</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-taskflow text-center py-3">
                    <div class="fs-3 fw-bold" style="color:#854d0e;"><?= $pendentes ?></div>
                    <div class="text-muted" style="font-size:.82rem;">Pendentes</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-taskflow text-center py-3">
                    <div class="fs-3 fw-bold text-success"><?= $concluidas ?></div>
                    <div class="text-muted" style="font-size:.82rem;">Concluídas</div>
                </div>
            </div>
        </div>

        <!-- ── Tabela de tarefas ── -->
        <div class="card card-taskflow">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-list-check"></i>
                Lista de Tarefas
                <span class="badge bg-white text-primary ms-auto"><?= $total ?></span>
            </div>
            <div class="card-body p-0">

                <?php if ($total === 0): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted mb-3">Nenhuma tarefa cadastrada.</p>
                    <a href="nova.php" class="btn btn-primary-brand btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Adicionar primeira tarefa
                    </a>
                </div>

                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-taskflow table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tarefas as $i => $tarefa): ?>
                            <tr>
                                <td class="text-muted" style="font-size:.82rem;"><?= $i + 1 ?></td>
                                <td>
                                    <div class="fw-semibold"><?= htmlspecialchars($tarefa['titulo']) ?></div>
                                    <?php if (!empty($tarefa['descricao'])): ?>
                                    <small class="text-muted">
                                        <?= htmlspecialchars(mb_strimwidth($tarefa['descricao'], 0, 60, '…')) ?>
                                    </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($tarefa['status'] === 'concluida'): ?>
                                        <span class="badge-concluida">
                                            <i class="bi bi-check-circle-fill me-1"></i>Concluída
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-pendente">
                                            <i class="bi bi-clock me-1"></i>Pendente
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-size:.85rem; color:#64748b;">
                                    <?= date('d/m/Y H:i', strtotime($tarefa['criado_em'])) ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <!-- Editar -->
                                        <a href="editar.php?id=<?= $tarefa['id'] ?>"
                                           class="btn btn-outline-primary btn-action"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                            <span class="d-none d-md-inline ms-1">Editar</span>
                                        </a>

                                        <!-- Concluir (só aparece se pendente) -->
                                        <?php if ($tarefa['status'] === 'pendente'): ?>
                                        <a href="concluir.php?id=<?= $tarefa['id'] ?>"
                                           class="btn btn-outline-success btn-action"
                                           title="Marcar como concluída"
                                           onclick="return confirm('Marcar tarefa como concluída?')">
                                            <i class="bi bi-check-lg"></i>
                                            <span class="d-none d-md-inline ms-1">Concluir</span>
                                        </a>
                                        <?php endif; ?>

                                        <!-- Excluir -->
                                        <a href="excluir.php?id=<?= $tarefa['id'] ?>"
                                           class="btn btn-outline-danger btn-action"
                                           title="Excluir"
                                           onclick="return confirm('Deseja excluir esta tarefa?')">
                                            <i class="bi bi-trash"></i>
                                            <span class="d-none d-md-inline ms-1">Excluir</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?php include 'layout_footer.php'; ?>
