<?php
// Ajuste as credenciais para o banco do laboratório.
$host='127.0.0.1'; $banco='estoque_didatico'; $usuarioBanco='root'; $senhaBanco='';
try {
    $pdo=new PDO("mysql:host={$host};dbname={$banco};charset=utf8mb4",$usuarioBanco,$senhaBanco,[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false
    ]);
} catch(PDOException $e) {
    http_response_code(500); exit('Falha na conexão. Confira config/conexao.php e o MySQL.');
}
