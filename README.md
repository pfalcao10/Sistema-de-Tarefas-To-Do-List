TaskFlow — Sistema de Gerenciamento de Tarefas (To-Do List)
Sistema web completo em PHP com MySQL, desenvolvido com Bootstrap 5.

📋 Requisitos
PHP 7.4+ (com extensão PDO e pdo_mysql)
MySQL 5.7+ / MariaDB 10.3+
Servidor web (Apache, Nginx ou PHP built-in server)
🚀 Instalação
1. Clone o repositório
git clone https://github.com/seu-usuario/taskflow-todo.git
cd taskflow-todo
2. Crie o banco de dados
No MySQL, execute o script SQL:

mysql -u root -p < banco.sql
Ou cole o conteúdo de banco.sql diretamente no phpMyAdmin.

3. Configure a conexão
Abra conexao.php e ajuste as credenciais:

$host     = 'localhost';
$dbname   = 'tarefas';
$username = 'root';
$password = '';
4. Inicie o servidor
# PHP built-in server (desenvolvimento)
php -S localhost:8080

# Ou coloque os arquivos na pasta htdocs / www do XAMPP/WAMP
5. Acesse no navegador
http://localhost:8080/login.php
Credenciais de teste:

Usuário: admin
Senha: 123456
📁 Estrutura de Arquivos
taskflow/
├── banco.sql          # Script SQL: cria banco, tabelas e usuário de teste
├── conexao.php        # Conexão PDO com MySQL
├── layout.php         # Header + Navbar compartilhada (Bootstrap 5)
├── layout_footer.php  # Rodapé compartilhado
├── login.php          # Autenticação (MD5 + sessão)
├── logout.php         # Encerramento de sessão
├── index.php          # Listagem de tarefas (página principal)
├── nova.php           # Cadastro de nova tarefa
├── editar.php         # Edição de tarefa existente
├── concluir.php       # Marca tarefa como concluída
├── excluir.php        # Exclusão de tarefa
└── README.md
🎨 Framework de Layout
Bootstrap 5 — importado via CDN em layout.php:

<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
Componentes utilizados: navbar, card, table, badge, btn, form-control, alert, breadcrumb.

⚙️ Funcionalidades
Funcionalidade	Arquivo
Login com MD5 + sessão	login.php
Logout	logout.php
Listagem de tarefas	index.php
Nova tarefa	nova.php
Editar tarefa	editar.php
Marcar como concluída	concluir.php
Excluir tarefa	excluir.php
🔒 Segurança
Todas as páginas protegidas verificam $_SESSION['usuario_id']
Senhas armazenadas como MD5
Todas as queries usam prepared statements (PDO)
Tarefas são isoladas por usuario_id — um usuário não acessa tarefas de outro
Saída HTML escapada com htmlspecialchars()
