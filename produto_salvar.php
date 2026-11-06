<?php
require_once 'includes/funcoes.php';exigirAdmin();exigirPostCsrf();require 'config/conexao.php';
$id=trim((string)($_POST['id']??''));$nome=trim((string)($_POST['nome']??''));$categoria=trim((string)($_POST['categoria']??''));
$preco=dinheiroValido((string)($_POST['preco']??''));
if($nome===''||mb_strlen($nome)>120||$categoria===''||mb_strlen($categoria)>80||$preco===null||($id!==''&&inteiroPositivo($id)===null)){
    aviso('danger','Preencha nome, categoria e preço válido (não negativo).');redirecionar('produtos.php');
}
if($id!==''){
    $s=$pdo->prepare('UPDATE produtos SET nome=?,categoria=?,preco=? WHERE id=?');$s->execute([$nome,$categoria,$preco,(int)$id]);
    aviso('success','Produto atualizado.');
}else{
    $s=$pdo->prepare('INSERT INTO produtos (nome,categoria,preco,quantidade) VALUES (?,?,?,0)');$s->execute([$nome,$categoria,$preco]);
    aviso('success','Produto cadastrado. Faça uma entrada para adicionar estoque.');
}
redirecionar('produtos.php');
