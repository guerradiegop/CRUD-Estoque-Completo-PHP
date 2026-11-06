<?php
require_once 'includes/funcoes.php';exigirAdmin();exigirPostCsrf();require 'config/conexao.php';
$id=inteiroPositivo($_POST['id']??null);
if(!$id){aviso('danger','Produto inválido.');redirecionar('produtos.php');}
try{
    // Produtos com histórico não podem ser removidos (FOREIGN KEY).
    $s=$pdo->prepare('DELETE FROM produtos WHERE id=? AND quantidade=0');$s->execute([$id]);
    aviso($s->rowCount()?'success':'warning',$s->rowCount()?'Produto excluído.':'Não é possível excluir: produto inexistente ou com saldo.');
}catch(PDOException $e){aviso('warning','Não é possível excluir um produto com movimentações no histórico.');}
redirecionar('produtos.php');
