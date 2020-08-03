<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../config/database.php';
include_once '../objects/product.php';
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
  
$product->product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die();
  
$product->readOne();
  
if($product->name!=null){
    $product_arr = array(
        "product_id" =>  $product->product_id,
        "name" => $product->name,
        "amount" => $product->amount,
        "qty_stock" => $product->qty_stock,
        "dt_sales" => $product->dt_sales,
        "amount_sales" => $product->amount_sales
    );
  
    http_response_code(200);

    echo json_encode($product_arr);
}
  
else{
    //Ajustar melhor os erros 400 e 500 neste caso.
    http_response_code(400);
    echo json_encode(array("Mensagem" => "Erro nos dados enviados"));
}
?>