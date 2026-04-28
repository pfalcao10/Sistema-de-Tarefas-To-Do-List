<?php
// concluir.php — Marca uma tarefa como concluída
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

if ($id > 0) {
    // Atualiza o status para "concluida" (apenas tarefas do usuário logado)
    $stmt = $pdo->prepare(
        "UPDATE tarefas SET status = 'concluida' WHERE id = ? AND usuario_id = ?"
    );
    $stmt->execute([$id, $usuario_id]);
}

header('Location: index.php');
exit;
?>
