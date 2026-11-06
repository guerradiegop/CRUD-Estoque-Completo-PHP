# Estoque Didático — PHP + PDO + MySQL

Sistema educacional de controle de estoque, com login, perfis administrador/operador, CRUD de produtos, dashboard, entradas e saídas, histórico, proteção CSRF e senhas com hash.

## Instalação

1. Instale XAMPP (PHP 8.1+, MySQL/MariaDB).
2. Coloque os arquivos na pasta `htdocs/estoque_didatico`.
3. Importe `sql/banco.sql` no phpMyAdmin.
4. Ajuste `config/conexao.php` conforme seu MySQL local.
5. Acesse `http://localhost/estoque_didatico/login.php`.
6. Usuário de laboratório: `admin@escola.local`; senha inicial: `Admin@12345!`. **Altere imediatamente a senha.**

Somente para uso didático; não publique em produção sem reforços adicionais de segurança.
