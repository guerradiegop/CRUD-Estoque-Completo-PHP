<?php
require_once 'includes/funcoes.php';exigirAdmin();require 'config/conexao.php';
$usuarios=$pdo->query('SELECT id,nome,email,perfil,ativo,criado_em FROM usuarios ORDER BY id')->fetchAll();
$titulo='Usuários';require 'includes/cabecalho.php';
?>
<h1 class="h3">Gerenciar usuários</h1><p class="text-secondary">Somente o administrador pode criar contas e ativar/desativar usuários.</p>
<div class="row g-4"><div class="col-lg-5"><form class="card card-body shadow-sm needs-validation" novalidate method="post" action="usuario_salvar.php">
<h2 class="h5">Criar usuário</h2><?= campoCsrf() ?>
<div class="mb-3"><label for="nome" class="form-label">Nome</label><input id="nome" name="nome" class="form-control" required maxlength="100"><div class="invalid-feedback">Informe o nome.</div></div>
<div class="mb-3"><label for="email" class="form-label">E-mail</label><input id="email" name="email" type="email" class="form-control" required maxlength="150"><div class="invalid-feedback">E-mail válido obrigatório.</div></div>
<div class="mb-3"><label for="senha" class="form-label">Senha inicial (mínimo 10 caracteres)</label><input id="senha" name="senha" type="password" class="form-control" required minlength="10" autocomplete="new-password"><div class="invalid-feedback">Use no mínimo 10 caracteres.</div></div>
<div class="mb-3"><label for="perfil" class="form-label">Perfil</label><select id="perfil" name="perfil" class="form-select"><option value="operador">Operador</option><option value="admin">Administrador</option></select></div><button class="btn btn-primary">Criar conta</button></form></div>
<div class="col-lg-7"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Nome</th><th>E-mail</th><th>Perfil</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($usuarios as $u): ?><tr><td><?= e($u['nome']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['perfil']) ?></td><td><?= (int)$u['ativo']?'Ativo':'Inativo' ?></td><td>
<?php if((int)$u['id']!==usuario()['id']): ?><form method="post" action="usuario_status.php" data-confirm="Alterar o status deste usuário?"><?= campoCsrf() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm btn-outline-secondary"><?= (int)$u['ativo']?'Desativar':'Ativar' ?></button></form><?php else: ?><small class="text-secondary">Você</small><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></div></div>
<?php require 'includes/rodape.php'; ?>
