<?php
require_once 'includes/funcoes.php';exigirLogin();require 'config/conexao.php';
$id=inteiroPositivo($_GET['produto_id']??null);
if(!$id){aviso('danger','Escolha um produto.');redirecionar('produtos.php');}
$s=$pdo->prepare('SELECT id,nome,quantidade FROM produtos WHERE id=?');$s->execute([$id]);$p=$s->fetch();
if(!$p){http_response_code(404);exit('Produto não encontrado.');}
$titulo='Movimentar estoque';require 'includes/cabecalho.php';
?>
<h1 class="h3">Entrada ou saída</h1><p>Produto: <strong><?= e($p['nome']) ?></strong> • Saldo atual: <strong><?= (int)$p['quantidade'] ?></strong></p>
<form class="card card-body shadow-sm needs-validation" novalidate method="post" action="movimento_salvar.php"><?= campoCsrf() ?><input type="hidden" name="produto_id" value="<?= (int)$p['id'] ?>">
<div class="mb-3"><label class="form-label" for="tipo">Tipo</label><select name="tipo" id="tipo" class="form-select" required><option value="entrada">Entrada (+)</option><option value="saida">Saída (-)</option></select></div>
<div class="mb-3"><label class="form-label" for="quantidade">Quantidade (inteiro maior que zero)</label><input type="number" name="quantidade" id="quantidade" class="form-control" min="1" step="1" required><div class="invalid-feedback">Digite uma quantidade positiva.</div></div>
<div class="mb-3"><label class="form-label" for="observacao">Observação (opcional)</label><textarea name="observacao" id="observacao" class="form-control" maxlength="255" rows="2" data-counter="contador"></textarea><small id="contador" class="text-secondary">0/255</small></div>
<div class="alert alert-info">Prévia do saldo: <strong id="saldo-previa" data-saldo="<?= (int)$p['quantidade'] ?>">—</strong></div>
<div><button class="btn btn-primary">Registrar movimentação</button> <a class="btn btn-outline-secondary" href="produtos.php">Voltar</a></div>
</form><?php require 'includes/rodape.php'; ?>
