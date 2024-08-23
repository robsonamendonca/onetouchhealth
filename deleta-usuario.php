<?php

require_once './config/conexao.php';

// Conexão com o banco
$database = new Conexao();
$db = $database->getConexao();

$id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);

$retorno = [];

if(empty($id)){
  $retorno = [ 'status'=>false, 'message'=> 'Parametro não foi informado.'];
    
}else{
    $sql_delete_usuario = "DELETE FROM usuarios WHERE id=:id";
    $delete_usuario = $db->prepare($sql_delete_usuario);
    $delete_usuario->bindParam(':id',$id);
    $delete_usuario->execute();
    if($delete_usuario->rowCount()){
        $retorno = [ 'status'=>true, 'message'=>"Usuário deletado com sucesso."];
    }else{
        $retorno = [ 'status'=>false, 'message'=>"Não foi possível deletar o usuário."];
    }
}

echo json_encode($retorno);