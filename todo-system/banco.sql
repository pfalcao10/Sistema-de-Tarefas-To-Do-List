-- banco.sql — Script de criação do banco de dados "tarefas"
-- Execute este arquivo no MySQL para configurar o sistema

CREATE DATABASE IF NOT EXISTS tarefas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE tarefas;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    senha   VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de tarefas
CREATE TABLE IF NOT EXISTS tarefas (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT NOT NULL,
    titulo      VARCHAR(255) NOT NULL,
    descricao   TEXT,
    status      ENUM('pendente','concluida') NOT NULL DEFAULT 'pendente',
    criado_em   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuário de teste: usuario="admin", senha=MD5("123456")
INSERT IGNORE INTO usuarios (usuario, senha)
VALUES ('admin', MD5('123456'));
