<?php
require_once 'includes/funcoes.php';exigirAdmin();require 'config/conexao.php';
$id=isset($_GET['id'])?inteiroPositivo($_GET['id']):null;
if(isset($_GET['id'])&&$id===null){http_response_code(400);exit('ID inválido.');}
$p=['id'=>'','nome'=>'','categoria'=>'','preco'=>'0.00'];
if($id){$s=$pdo->prepare('SELECT * FROM produtos WHERE id=?');$s->execute([$id]);$p=$s->fetch();if(!$p){http_response_code(404);exit('Produto não encontrado.');}}
$titulo=$id?'Editar produto':'Novo produto';require 'includes/cabecalho.php';
?>
<h1 class="h3"><?= e($titulo) ?></h1><p class="text-secondary">A quantidade não é editada aqui: use uma entrada ou saída para manter o histórico.</p>
<form action="produto_salvar.php" method="post" class="card card-body shadow-sm needs-validation" novalidate><?= campoCsrf() ?><input type="hidden" name="id" value="<?= e((string)$p['id']) ?>">
<div class="mb-3"><label for="nome" class="form-label">Nome</label><input id="nome" name="nome" class="form-control" maxlength="120" required value="<?= e($p['nome']) ?>"><div class="invalid-feedback">Informe o nome.</div></div>
<div class="mb-3"><label for="categoria" class="form-label">Categoria</label><input id="categoria" name="categoria" class="form-control" maxlength="80" required value="<?= e($p['categoria']) ?>"><div class="invalid-feedback">Informe a categoria.</div></div>
<div class="mb-3"><label for="preco" class="form-label">Preço (use ponto ou vírgula)</label><input id="preco" name="preco" class="form-control" inputmode="decimal" required value="<?= e((string)$p['preco']) ?>"><div class="invalid-feedback">Informe o preço.</div></div>
<div><button class="btn btn-primary">Salvar</button> <a href="produtos.php" class="btn btn-outline-secondary">Cancelar</a></div></form>
<?php require 'includes/rodape.php'; ?>
