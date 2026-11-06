<?php
require_once 'includes/funcoes.php';exigirLogin();exigirPostCsrf();require 'config/conexao.php';
$produto=inteiroPositivo($_POST['produto_id']??null);
$qtd=inteiroPositivo($_POST['quantidade']??null);
$tipo=(string)($_POST['tipo']??'');$obs=trim((string)($_POST['observacao']??''));
if(!$produto||!$qtd||!in_array($tipo,['entrada','saida'],true)||mb_strlen($obs)>255){
    aviso('danger','Movimentação inválida.');redirecionar('produtos.php');
}
try{
    $pdo->beginTransaction();
    // FOR UPDATE bloqueia o registro até finalizar a transação.
    $s=$pdo->prepare('SELECT quantidade FROM produtos WHERE id=? FOR UPDATE');$s->execute([$produto]);$p=$s->fetch();
    if(!$p)throw new RuntimeException('Produto não encontrado.');
    $saldo=(int)$p['quantidade'];
    if($tipo==='saida'&&$qtd>$saldo)throw new RuntimeException('Estoque insuficiente para a saída.');
    if($tipo==='entrada'&&$qtd>4294967295-$saldo)throw new RuntimeException('Quantidade acima do limite permitido.');
    $novoSaldo=$tipo==='entrada'?$saldo+$qtd:$saldo-$qtd;
    $s=$pdo->prepare('UPDATE produtos SET quantidade=? WHERE id=?');$s->execute([$novoSaldo,$produto]);
    $s=$pdo->prepare('INSERT INTO movimentacoes (produto_id,usuario_id,tipo,quantidade,observacao) VALUES (?,?,?,?,?)');
    $s->execute([$produto,usuario()['id'],$tipo,$qtd,$obs===''?null:$obs]);
    $pdo->commit();aviso('success','Movimentação registrada. Saldo atual: '.$novoSaldo.'.');
}catch(RuntimeException $e){
    if($pdo->inTransaction())$pdo->rollBack();aviso('warning',$e->getMessage());
}catch(Throwable $e){
    if($pdo->inTransaction())$pdo->rollBack();aviso('danger','Não foi possível registrar a movimentação.');
}
redirecionar('movimentacoes.php');
