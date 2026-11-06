<?php
require_once 'includes/funcoes.php';exigirAdmin();exigirPostCsrf();require 'config/conexao.php';
$id=inteiroPositivo($_POST['id']??null);
if(!$id||$id===usuario()['id']){aviso('warning','Não é possível alterar sua própria conta.');redirecionar('usuarios.php');}
$s=$pdo->prepare('UPDATE usuarios SET ativo=IF(ativo=1,0,1) WHERE id=?');$s->execute([$id]);
aviso('success','Status atualizado.');redirecionar('usuarios.php');
