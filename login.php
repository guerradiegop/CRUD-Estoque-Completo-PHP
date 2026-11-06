<?php
require_once 'includes/funcoes.php';
if(autenticado())redirecionar('index.php');
$erro='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    exigirPostCsrf();
    $email=strtolower(trim((string)($_POST['email']??'')));
    $senha=(string)($_POST['senha']??'');
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)||$senha==='')$erro='Informe e-mail e senha válidos.';
    else{
        require 'config/conexao.php';
        $s=$pdo->prepare('SELECT id,nome,email,senha_hash,perfil,ativo FROM usuarios WHERE email=? LIMIT 1');
        $s->execute([$email]);$u=$s->fetch();
        if($u && (int)$u['ativo']===1 && password_verify($senha,$u['senha_hash'])){
            session_regenerate_id(true);
            $_SESSION['usuario']=['id'=>(int)$u['id'],'nome'=>$u['nome'],'email'=>$u['email'],'perfil'=>$u['perfil']];
            $_SESSION['csrf']=bin2hex(random_bytes(32));
            aviso('success','Bem-vindo(a), '.$u['nome'].'!');
            redirecionar('index.php');
        }
        $erro='E-mail ou senha incorretos.';
    }
}
?><!doctype html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login • Estoque Didático</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="assets/css/estilo.css"></head>
<body class="login-fundo"><main class="card shadow login-cartao p-4"><h1 class="h3 mb-2">📦 Acesso ao estoque</h1><p class="text-secondary">Entre com as credenciais fornecidas pelo professor.</p>
<?php if($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
<form method="post"><?= campoCsrf() ?>
<div class="mb-3"><label for="email" class="form-label">E-mail</label><input class="form-control" name="email" id="email" type="email" required maxlength="150" autocomplete="username" value="<?= e((string)($_POST['email']??'')) ?>"></div>
<div class="mb-3"><label for="senha" class="form-label">Senha</label><div class="input-group"><input class="form-control" name="senha" id="senha" type="password" required autocomplete="current-password"><button class="btn btn-outline-secondary" type="button" data-toggle-password="senha">Mostrar</button></div></div>
<button class="btn btn-primary w-100">Entrar</button></form></main><script src="assets/js/app.js"></script></body></html>
