<?php // Inclua após exigirLogin() e defina $titulo se desejar. ?>
<!doctype html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($titulo??'Estoque Didático') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/estilo.css"></head><body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4"><div class="container">
<a class="navbar-brand fw-bold" href="index.php">📦 Estoque Didático</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Alternar menu"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="menu"><div class="navbar-nav me-auto">
<a class="nav-link" href="index.php">Dashboard</a><a class="nav-link" href="produtos.php">Produtos</a>
<a class="nav-link" href="movimentacoes.php">Movimentações</a>
<?php if(administrador()): ?><a class="nav-link" href="usuarios.php">Usuários</a><?php endif; ?>
<a class="nav-link" href="senha.php">Minha senha</a>
</div><span class="navbar-text text-white me-3"><?= e(usuario()['nome']) ?> (<?= e(usuario()['perfil']) ?>)</span>
<form method="post" action="logout.php" class="m-0"><?= campoCsrf() ?><button class="btn btn-outline-light btn-sm">Sair</button></form>
</div></div></nav><main class="container pb-5"><?php mostrarAviso(); ?>
