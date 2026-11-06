<?php
// Funções comuns: sessão, autenticação, autorização, CSRF e validações.
if(session_status()!==PHP_SESSION_ACTIVE) {
    if(PHP_SAPI!=='cli' && !headers_sent()) {
        ini_set('session.use_strict_mode','1');
        session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off','samesite'=>'Lax','path'=>'/']);
    }
    session_start();
}
function e(?string $texto):string{return htmlspecialchars((string)$texto,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function redirecionar(string $url):never{header('Location: '.$url);exit;}
function usuario():?array{return $_SESSION['usuario']??null;}
function autenticado():bool{return usuario()!==null;}
function exigirLogin():void{if(!autenticado())redirecionar('login.php');}
function administrador():bool{return autenticado() && usuario()['perfil']==='admin';}
function exigirAdmin():void{exigirLogin();if(!administrador()){http_response_code(403);exit('Acesso negado: somente administrador.');}}
function tokenCsrf():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function campoCsrf():string{return '<input type="hidden" name="csrf" value="'.e(tokenCsrf()).'">';}
function exigirPostCsrf():void{
    if(($_SERVER['REQUEST_METHOD']??'')!=='POST' || !hash_equals(tokenCsrf(),(string)($_POST['csrf']??''))){
        http_response_code(419);exit('Requisição inválida (CSRF). Recarregue a página.');
    }
}
function aviso(string $tipo,string $mensagem):void{$_SESSION['aviso']=['tipo'=>$tipo,'mensagem'=>$mensagem];}
function mostrarAviso():void{
    if(!isset($_SESSION['aviso']))return;
    $a=$_SESSION['aviso'];unset($_SESSION['aviso']);
    $tipo=in_array($a['tipo'],['success','danger','warning','info'],true)?$a['tipo']:'info';
    echo '<div class="alert alert-'.$tipo.' alert-dismissible fade show" role="alert">'.e($a['mensagem']).'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button></div>';
}
function inteiroPositivo(mixed $v):?int{$n=filter_var($v,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);return $n===false?null:$n;}
function dinheiroValido(string $v):?string{
    $v=trim(str_replace(',','.',$v));
    if(!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/',$v))return null;
    return number_format((float)$v,2,'.','');
}
