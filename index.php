<?php
require_once 'includes/funcoes.php'; exigirLogin(); require 'config/conexao.php';
// Consultas agregadas com COUNT, SUM e CASE.
$dados=$pdo->query('SELECT COUNT(*) total_produtos, COALESCE(SUM(quantidade),0) unidades, COALESCE(SUM(preco*quantidade),0) valor, COALESCE(SUM(CASE WHEN quantidade<=5 THEN 1 ELSE 0 END),0) baixos FROM produtos')->fetch();
$recentes=$pdo->query('SELECT m.tipo,m.quantidade,m.criado_em,p.nome produto,u.nome responsavel FROM movimentacoes m JOIN produtos p ON p.id=m.produto_id JOIN usuarios u ON u.id=m.usuario_id ORDER BY m.id DESC LIMIT 6')->fetchAll();
$titulo='Dashboard';require 'includes/cabecalho.php';
?>
<h1 class="h3">Painel de estoque</h1><p class="text-secondary">Consultas SQL resumidas em indicadores.</p>
<div class="row g-3 mb-4">
<?php foreach([['Produtos',$dados['total_produtos']],['Unidades no estoque',$dados['unidades']],['Valor do estoque','R$ '.number_format((float)$dados['valor'],2,',','.')],['Estoque baixo (≤ 5)',$dados['baixos']]] as $card): ?>
<div class="col-12 col-sm-6 col-xl-3"><div class="card shadow-sm h-100"><div class="card-body"><div class="text-secondary small"><?= e((string)$card[0]) ?></div><div class="h3 mt-2 mb-0"><?= e((string)$card[1]) ?></div></div></div></div>
<?php endforeach; ?></div>
<div class="d-flex justify-content-between align-items-center mb-2"><h2 class="h5 mb-0">Últimas movimentações</h2><a href="movimentacoes.php" class="btn btn-sm btn-outline-primary">Ver histórico</a></div>
<div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>Produto</th><th>Tipo</th><th>Qtd.</th><th>Responsável</th><th>Data</th></tr></thead><tbody>
<?php foreach($recentes as $r): ?><tr><td><?= e($r['produto']) ?></td><td><span class="badge text-bg-<?= $r['tipo']==='entrada'?'success':'warning' ?>"><?= e($r['tipo']) ?></span></td><td><?= (int)$r['quantidade'] ?></td><td><?= e($r['responsavel']) ?></td><td><?= e($r['criado_em']) ?></td></tr><?php endforeach; ?>
<?php if(!$recentes): ?><tr><td colspan="5" class="text-secondary">Ainda não há movimentações.</td></tr><?php endif; ?>
</tbody></table></div><?php require 'includes/rodape.php'; ?>
