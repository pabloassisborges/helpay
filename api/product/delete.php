<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../config/database.php';
include_once '../objects/product.php';
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));
  
$product->product_id = $data->product_id;
  
if($product->delete()){
    //Inserir aqui um try-catch para testar se existe o product_id
    http_response_code(200);
    echo json_encode(array("Mensagem" => "Produto excluído com sucesso"));
}
  
else{
    http_response_code(500);
    echo json_encode(array("Mensagem" => "Erro interno no servidor"));
}
?>