<?php
// excluir.php — Exclui uma tarefa
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
    // Exclui apenas tarefas que pertencem ao usuário logado
    $stmt = $pdo->prepare(
        'DELETE FROM tarefas WHERE id = ? AND usuario_id = ?'
    );
    $stmt->execute([$id, $usuario_id]);
}

header('Location: index.php');
exit;
?>
