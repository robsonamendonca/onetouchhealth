<?php

require_once './config/conexao.php';

// Conexão com o banco
$database = new Conexao();
$db = $database->getConexao();

$usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome = "";
$email = "";
$retorno = [];

if(empty($usuario['nome'])){
  $retorno = [ 'status'=>false, 'message'=> $usuario];
}
elseif(mb_strlen($usuario['nome'])<3){
    $retorno = [ 'status'=>false, 'message'=>"Nome precisa ter mais do que 2 caracteres."];
}
elseif(mb_strlen($usuario['nome'])>100){
    $retorno = [ 'status'=>false, 'message'=>"Nome não pode ter mais do que 100 caracteres."];
}
elseif(empty($usuario['email'])){
    $retorno = [ 'status'=>false, 'message'=>"E-mail precisa ser preenchido."];
}
elseif(!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)) {
    $retorno = [ 'status'=>false, 'message'=>"E-mail esta no formato invalido."];
}
elseif(mb_strlen($usuario['email'])>100){
    $retorno = [ 'status'=>false, 'message'=>"E-mail não pode ter mais do que 100 caracteres."];
    
}else{
    $nome = $usuario['nome'];
    $email = $usuario['email'];    
    $sql_insert_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
    $novo_usuario = $db->prepare($sql_insert_usuario);
    $novo_usuario->bindParam(':nome',$nome);
    $novo_usuario->bindParam(':email',$email);
    $novo_usuario->execute();
    if($novo_usuario->rowCount()){
        $retorno = [ 'status'=>true, 'message'=>"Usuário adicionado com sucesso."];
    }else{
        $retorno = [ 'status'=>false, 'message'=>"Não foi possível adicionar o usuário."];
    }
}

echo json_encode($retorno);