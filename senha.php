<?php
require_once 'includes/funcoes.php';exigirLogin();require 'config/conexao.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    exigirPostCsrf();
    $atual=(string)($_POST['atual']??'');$nova=(string)($_POST['nova']??'');
    $s=$pdo->prepare('SELECT senha_hash FROM usuarios WHERE id=?');$s->execute([usuario()['id']]);$u=$s->fetch();
    if(!$u||!password_verify($atual,$u['senha_hash'])||strlen($nova)<10){
        aviso('danger','Senha atual incorreta ou nova senha com menos de 10 caracteres.');
    }else{
        $hash=password_hash($nova,PASSWORD_DEFAULT);
        $s=$pdo->prepare('UPDATE usuarios SET senha_hash=? WHERE id=?');$s->execute([$hash,usuario()['id']]);
        aviso('success','Senha alterada com sucesso.');
    }
    redirecionar('senha.php');
}
$titulo='Alterar senha';require 'includes/cabecalho.php';
?>
<h1 class="h3">Alterar minha senha</h1><p class="text-secondary">Troque imediatamente a senha padrão do administrador.</p>
<form method="post" class="card card-body shadow-sm needs-validation" novalidate style="max-width:530px"><?= campoCsrf() ?>
<div class="mb-3"><label class="form-label" for="atual">Senha atual</label><input class="form-control" type="password" name="atual" id="atual" required autocomplete="current-password"></div>
<div class="mb-3"><label class="form-label" for="nova">Nova senha (mínimo 10 caracteres)</label><input class="form-control" type="password" name="nova" id="nova" required minlength="10" autocomplete="new-password"><div class="invalid-feedback">Informe pelo menos 10 caracteres.</div></div>
<button class="btn btn-primary">Salvar nova senha</button></form>
<?php require 'includes/rodape.php'; ?>
