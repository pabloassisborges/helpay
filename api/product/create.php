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
  

if(
    !empty($data->name) &&
    !empty($data->amount) &&
    !empty($data->qty_stock)
){
  
    $product->name = $data->name;
    $product->price = $data->price;
    $product->qty_stock = $data->qty_stock;
    $product->dt_sales = null;
    $product->amount_sales = null;
  

    if($product->create()){
        http_response_code(200);
        echo json_encode(array("Mensagem" => "Produto criado."));
    }
  
    else{
        http_response_code(500);
        echo json_encode(array("Mensagem" => "Erro interno no servidor."));
    }
}
  
else{
    http_response_code(400);
    echo json_encode(array("Mensagem" => "Erro nos dados enviados."));
}
?>