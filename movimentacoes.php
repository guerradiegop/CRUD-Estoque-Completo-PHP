<?php
require_once 'includes/funcoes.php';exigirLogin();require 'config/conexao.php';
$tipo=(string)($_GET['tipo']??'');if(!in_array($tipo,['entrada','saida'],true))$tipo='';
$sql='SELECT m.id,m.tipo,m.quantidade,m.observacao,m.criado_em,p.nome produto,u.nome responsavel FROM movimentacoes m JOIN produtos p ON p.id=m.produto_id JOIN usuarios u ON u.id=m.usuario_id';
if($tipo!=='')$sql.=' WHERE m.tipo = ?';
$sql.=' ORDER BY m.id DESC LIMIT 100';
$s=$pdo->prepare($sql);$s->execute($tipo!==''?[$tipo]:[]);$movs=$s->fetchAll();
$titulo='Histórico de movimentações';require 'includes/cabecalho.php';
?>
<h1 class="h3">Histórico de movimentações</h1><p class="text-secondary">Mostrando até 100 registros mais recentes. O histórico não pode ser editado ou excluído nesta versão.</p>
<form class="d-flex gap-2 mb-3" method="get"><select name="tipo" class="form-select w-auto" aria-label="Filtrar tipo"><option value="">Todos os tipos</option><option value="entrada" <?= $tipo==='entrada'?'selected':'' ?>>Entradas</option><option value="saida" <?= $tipo==='saida'?'selected':'' ?>>Saídas</option></select><button class="btn btn-outline-primary">Filtrar</button><a href="produtos.php" class="btn btn-primary">Movimentar produto</a></form>
<div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Qtd.</th><th>Responsável</th><th>Observação</th></tr></thead><tbody>
<?php foreach($movs as $m): ?><tr><td><?= e($m['criado_em']) ?></td><td><?= e($m['produto']) ?></td><td><span class="badge text-bg-<?= $m['tipo']==='entrada'?'success':'warning' ?>"><?= e($m['tipo']) ?></span></td><td><?= (int)$m['quantidade'] ?></td><td><?= e($m['responsavel']) ?></td><td><?= e($m['observacao']??'') ?></td></tr><?php endforeach; ?>
<?php if(!$movs): ?><tr><td colspan="6">Nenhuma movimentação cadastrada.</td></tr><?php endif; ?></tbody></table></div>
<?php require 'includes/rodape.php'; ?>
