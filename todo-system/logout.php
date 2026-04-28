<?php
// logout.php — Encerramento de sessão
session_start();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
?>
