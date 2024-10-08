<?php
 
/*
 * DataTables example server-side processing script.
 *
*/ 
require_once './config/conexao.php';

// Conexão com o banco
$database = new Conexao();
$db = $database->getConexao();
 
$columns = array(
    0 => 'id',
    1 => 'nome',
    2 => 'email'
);

$requisicao = $_REQUEST;
$flag_filtro = false;
$sql_where = "";
$conteudo_filtro = "";
if(!empty($requisicao['search']['value'])){
    $flag_filtro = true;
    $conteudo_filtro = "%". $requisicao['search']['value'] . "%";
    $sql_where = "WHERE id LIKE :id
                    OR nome LIKE :nome
                    OR email LIKE :email  
    ";
}


$sql_count_usuarios = "SELECT COUNT(*) AS qtd FROM usuarios ";
$result_qtd_usuarios = $db->prepare($sql_count_usuarios);
if($flag_filtro == true){
    $result_qtd_usuarios->execute();
    $qtd_usuarios_total = $result_qtd_usuarios->fetch(PDO::FETCH_ASSOC);
    
    $result_qtd_usuarios_filtro = $db->prepare($sql_count_usuarios . $sql_where);
    $result_qtd_usuarios_filtro->bindParam(':id', $conteudo_filtro, PDO::PARAM_STR);
    $result_qtd_usuarios_filtro->bindParam(':nome', $conteudo_filtro, PDO::PARAM_STR);
    $result_qtd_usuarios_filtro->bindParam(':email', $conteudo_filtro, PDO::PARAM_STR);  
    $result_qtd_usuarios_filtro->execute();  
    $qtd_usuarios_filtrada = $result_qtd_usuarios_filtro->fetch(PDO::FETCH_ASSOC);

}else{
    $result_qtd_usuarios->execute();
    $qtd_usuarios_total = $result_qtd_usuarios->fetch(PDO::FETCH_ASSOC);   
    $qtd_usuarios_filtrada = $qtd_usuarios_total;
}

$sql_usuarios = "SELECT id, nome, email 
                    FROM usuarios
                    {$sql_where}
                    ORDER BY " . $columns[$requisicao['order'][0]['column']] . " ". $requisicao['order'][0]['dir'] ."
                    LIMIT :inicio , :intervalo                   
";

$result_usuarios = $db->prepare($sql_usuarios);
if($flag_filtro == true){
    $result_usuarios->bindParam(':id', $conteudo_filtro, PDO::PARAM_STR);
    $result_usuarios->bindParam(':nome', $conteudo_filtro, PDO::PARAM_STR);
    $result_usuarios->bindParam(':email', $conteudo_filtro, PDO::PARAM_STR);    
}
$result_usuarios->bindParam(':inicio', $requisicao['start'], PDO::PARAM_INT);
$result_usuarios->bindParam(':intervalo', $requisicao['length'], PDO::PARAM_INT);
$result_usuarios->execute();

while ($usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
    extract($usuario);
    $row_usuario = [];
    $row_usuario [] = $id;
    $row_usuario [] = $nome;
    $row_usuario []= $email;
    $row_usuario []= "<a id='$id' class='text-decoration-none' href='#' onclick='deletarUsuario($id)' > ❌</a>";

    $lista_usuarios[] = $row_usuario;
}

$retorno_dados= [
    "draw" => intval($requisicao['draw']), 
    "recordsTotal" =>intval( $qtd_usuarios_total['qtd']), 
    "recordsFiltered" => intval( $qtd_usuarios_filtrada['qtd']) , 
    "data" => isset($lista_usuarios) ? $lista_usuarios : [] 
];
    
echo json_encode($retorno_dados);