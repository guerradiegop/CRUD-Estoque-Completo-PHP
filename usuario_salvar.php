<?php
require_once 'includes/funcoes.php';exigirAdmin();exigirPostCsrf();require 'config/conexao.php';
$nome=trim((string)($_POST['nome']??''));$email=strtolower(trim((string)($_POST['email']??'')));
$senha=(string)($_POST['senha']??'');$perfil=(string)($_POST['perfil']??'');
if($nome===''||mb_strlen($nome)>100||!filter_var($email,FILTER_VALIDATE_EMAIL)||mb_strlen($email)>150||strlen($senha)<10||!in_array($perfil,['admin','operador'],true)){
    aviso('danger','Confira os dados (senha com pelo menos 10 caracteres).');redirecionar('usuarios.php');
}
try{
    // Só o hash seguro é armazenado, nunca a senha original.
    $hash=password_hash($senha,PASSWORD_DEFAULT);
    $s=$pdo->prepare('INSERT INTO usuarios (nome,email,senha_hash,perfil) VALUES (?,?,?,?)');
    $s->execute([$nome,$email,$hash,$perfil]);
    aviso('success','Usuário criado. Oriente-o a alterar a senha inicial.');
}catch(PDOException $e){aviso('danger','Não foi possível cadastrar. Verifique se o e-mail já existe.');}
redirecionar('usuarios.php');
