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

//verifica informações do cartão
if(strlen($data->card->card_number) != 16 && strlen($data->card->cvv) <= 3 ){
    http_response_code(400);
    echo json_encode(array("Mensagem" => "Erro nos dados enviados."));
} else {
    //Transforma JSON em XML
    $data_array = $data;
    $xml = new SimpleXMLElement('<dados/>');
    array_walk_recursive($data_array, array ($xml, 'addChild'));
    print $xml->asXML();
    
    //Conecta com Google Drive e salva XML
    //Envia SMTP com link do Google Drive
    //Envia pro Gateway de pagamento
    //Realiza update
    $product->product_id = $data->product_id;
    $product->qty_stock = $product->qty_stock - $data->qty_stock;

    if($product->update()){

        http_response_code(200);
        echo json_encode(array("Mensagem" => "Produto atualizado"));
    }
      
    else{
        //Estruturar os erros 400 e 500 para essa operação
        http_response_code(500);
        echo json_encode(array("Mensagem" => "Erro interno no servidor"));
    }
}

?>
