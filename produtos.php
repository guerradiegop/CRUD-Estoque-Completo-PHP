<?php
require_once 'includes/funcoes.php'; exigirLogin(); require 'config/conexao.php';
$busca=trim((string)($_GET['busca']??''));
// Busca parametrizada com LIKE.
$s=$pdo->prepare('SELECT * FROM produtos WHERE nome LIKE ? OR categoria LIKE ? ORDER BY nome');
$s->execute(['%'.$busca.'%','%'.$busca.'%']);$produtos=$s->fetchAll();
$titulo='Produtos';require 'includes/cabecalho.php';
?>
<div class="d-flex justify-content-between align-items-center gap-2 mb-3"><h1 class="h3 mb-0">Produtos</h1><?php if(administrador()): ?><a href="produto_form.php" class="btn btn-primary">+ Novo produto</a><?php endif; ?></div>
<form class="row g-2 mb-3" method="get"><div class="col-sm-9"><label class="visually-hidden" for="busca">Buscar</label><input class="form-control" name="busca" id="busca" value="<?= e($busca) ?>" placeholder="Nome ou categoria"></div><div class="col-sm-3"><button class="btn btn-outline-primary w-100">Pesquisar</button></div></form>
<div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Produto</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead><tbody>
<?php foreach($produtos as $p): ?><tr><td><?= e($p['nome']) ?></td><td><?= e($p['categoria']) ?></td><td>R$ <?= number_format((float)$p['preco'],2,',','.') ?></td><td><span class="badge text-bg-<?= (int)$p['quantidade']<=5?'warning':'success' ?>"><?= (int)$p['quantidade'] ?></span></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="movimento_form.php?produto_id=<?= (int)$p['id'] ?>">Movimentar</a>
<?php if(administrador()): ?><a class="btn btn-sm btn-outline-secondary" href="produto_form.php?id=<?= (int)$p['id'] ?>">Editar</a><form method="post" action="produto_excluir.php" class="d-inline" data-confirm="Excluir este produto?"><?= campoCsrf() ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Excluir</button></form><?php endif; ?></td></tr><?php endforeach; ?>
<?php if(!$produtos): ?><tr><td colspan="5">Nenhum produto encontrado.</td></tr><?php endif; ?></tbody></table></div>
<?php require 'includes/rodape.php'; ?>
