<?php
// conexao.php — Conexão com o banco de dados MySQL via PDO

$host = 'localhost';
$dbname = 'tarefas';
$username = 'root';
$password = 'ceub123456';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die('<div style="font-family:sans-serif;padding:2rem;color:#dc3545;">
        <h3>Erro de Conexão</h3>
        <p>' . htmlspecialchars($e->getMessage()) . '</p>
    </div>');
}
?>
