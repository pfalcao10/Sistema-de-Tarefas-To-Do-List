🚀 TaskFlow — Sistema de Gerenciamento de Tarefas (To-Do List)

Sistema web completo desenvolvido em PHP + MySQL, utilizando Bootstrap 5 para o layout e interface visual.
O projeto permite autenticação de usuários com sessão e gerenciamento completo de tarefas (CRUD), seguindo os requisitos acadêmicos da atividade proposta.

📋 Requisitos
PHP 7.4+ (com extensão PDO e pdo_mysql)
MySQL 5.7+ ou MariaDB 10.3+
Servidor Web (Apache, Nginx ou PHP Built-in Server)
XAMPP / WAMP / Laragon (recomendado para ambiente local)
🚀 Instalação
1️⃣ Clone o repositório
git clone https://github.com/seu-usuario/taskflow-todo.git
cd taskflow-todo
2️⃣ Crie o banco de dados

O banco obrigatório deve se chamar:

tarefas

Execute o script SQL:

mysql -u root -p < banco.sql

ou cole o conteúdo do arquivo banco.sql diretamente no phpMyAdmin.

3️⃣ Configure a conexão com o banco

Abra o arquivo:

conexao.php

e ajuste suas credenciais:

<?php

$host     = 'localhost';
$dbname   = 'tarefas';
$username = 'root';
$password = 'ceub123456';

?>
4️⃣ Inicie o servidor
Usando PHP Built-in Server
php -S localhost:8080
Ou usando XAMPP / WAMP

Coloque os arquivos dentro da pasta:

htdocs

ou

www
5️⃣ Acesse no navegador
http://localhost:8080/login.php

ou

http://localhost/taskflow/login.php
🔐 Credenciais de Teste

O professor exige um usuário padrão:

Usuário: admin
Senha: 123456

A senha deve estar salva no banco utilizando:

MD5("123456")

Resultado:

e10adc3949ba59abbe56e057f20f883e
📁 Estrutura de Arquivos
taskflow/
│
├── banco.sql          # Script SQL: cria banco, tabelas e usuário de teste
├── conexao.php        # Conexão PDO com MySQL
├── layout.php         # Header + Navbar compartilhada
├── layout_footer.php  # Rodapé compartilhado
│
├── login.php          # Login com MD5 + sessão
├── logout.php         # Encerramento de sessão
│
├── index.php          # Página principal / listagem de tarefas
├── nova.php           # Cadastro de nova tarefa
├── editar.php         # Edição de tarefa
├── concluir.php       # Marca tarefa como concluída
├── excluir.php        # Exclusão de tarefa
│
└── README.md
🎨 Framework de Layout

Framework obrigatório utilizado:

Bootstrap 5

Importado via CDN:

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

Componentes utilizados:

Navbar
Cards
Tabelas estilizadas
Badges coloridas
Botões Bootstrap
Alerts de erro
Formulários com form-control
Breadcrumbs
⚙️ Funcionalidades
Funcionalidade	Arquivo
Login com MD5 + Sessão	login.php
Logout	logout.php
Listagem de tarefas	index.php
Nova tarefa	nova.php
Editar tarefa	editar.php
Marcar como concluída	concluir.php
Excluir tarefa	excluir.php
📌 Regras exigidas pelo professor

O sistema obrigatoriamente possui:

Login protegido por sessão
Verificação com session_start()
$_SESSION["usuario_id"]
$_SESSION["usuario"]
Logout com session_destroy()
CRUD completo de tarefas
Prepared Statements com PDO
Status com:
pendente
concluida
Badge VERDE para concluída
Badge AMARELA para pendente
Navbar com nome do usuário logado
Layout compartilhado com include()
Código publicado no GitHub
🔒 Segurança

O sistema possui:

Proteção de sessão em todas as páginas privadas
Verificação de $_SESSION['usuario_id']
Senhas armazenadas em MD5
Prepared Statements (PDO)
Proteção contra SQL Injection
Tarefas separadas por usuario_id
Saída HTML protegida com htmlspecialchars()
🧠 Conceitos aplicados

Este projeto utiliza:

CRUD completo
Login e autenticação
Sessões em PHP
Banco de dados relacional
PDO + Prepared Statements
Segurança básica
Bootstrap 5
Organização profissional de projeto
Git + GitHub
📚 Projeto acadêmico

Projeto desenvolvido para atividade avaliativa da disciplina de Desenvolvimento Web / PHP.

Tema:

Sistema de Tarefas — To-Do List

Objetivo:

Criar um sistema funcional com autenticação de usuários e gerenciamento completo de tarefas utilizando PHP + MySQL + Bootstrap.

👨‍💻 Autor

Projeto desenvolvido por:

Seu Nome Aqui

GitHub:

https://github.com/pfalcao10
