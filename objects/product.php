<?php

class Product{
  
    // conexão com banco de dados e nome da tabela
    private $conn;
    private $table_name = "products";
  
    // propriedades do objeto
    public $product_id;
    public $name;
    public $amount;
    public $qty_stock;
    public $dt_sales;
    public $amount_sales;
  
    // construtor com $db como conexão com o banco de dados
    public function __construct($db){
        $this->conn = $db;
    }

    // lê produtos
    function read(){
        // query de leitura
        $query = "SELECT name, amount, qty_stock FROM ". $this->table_name ." WHERE qty_stock > 0";
        $stmt = $this->conn->prepare($query);

        // executa
        $stmt->execute();
        return $stmt;
    }

    // cria um produto
    function create(){
  
        // query de inserção de produto
        $query = "INSERT INTO" . $this->table_name . "SET name=:name, amount=:amount, qty_stock=:qty_stock, dt_sales=:". null .", amount_sales=:". null ."";
        $stmt = $this->conn->prepare($query);
  
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->qty_stock=htmlspecialchars(strip_tags($this->qty_stock));
        $this->dt_sales=htmlspecialchars(strip_tags($this->dt_sales));
        $this->amount_sales=htmlspecialchars(strip_tags($this->amount_sales));
  
        // bind
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":qty_stock", $this->qty_stock);
        $stmt->bindParam(":dt_sales", $this->dt_sales);
        $stmt->bindParam(":amount_sales", $this->amount_sales);
  
        // executa
        if($stmt->execute()){
            return true;
        }
        return false;
    }



}

?>