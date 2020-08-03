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

    // lê um registro e retorna detalhes
    function readOne(){
  
        // query
        $query = "SELECT * FROM" . $this->table_name . "WHERE product_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );
  
        // bind
        $stmt->bindParam(1, $this->id);
  
        // executa
        $stmt->execute();
  
        // ROW recebida
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->product_id = $row['product_id'];
        $this->name = $row['name'];
        $this->amount = $row['amount'];
        $this->qty_stock = $row['qty_stock'];
        $this->dt_sales = $row['dt_sales'];
        $this->amount_sales = $row['amount_sales'];
    }

    // Update do Produto
    function update(){
  
        // query
        $query = "UPDATE" . $this->table_name . "SET qty_stock = :qty_stock, dt_sales = :dt_sales, amount_sales = :amount_sales WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
  
        // sanitize
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->qty_stock=htmlspecialchars(strip_tags($this->qty_stock));
        $this->dt_sales=htmlspecialchars(strip_tags($this->dt_sales));
        $this->amount_sales=htmlspecialchars(strip_tags($this->amount_sales));
  
        // bind
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(":qty_stock", $this->qty_stock);
        $stmt->bindParam(":dt_sales", $this->dt_sales);
        $stmt->bindParam(":amount_sales", $this->amount_sales);
  
        // executa
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Deleta o produto
    function delete(){
  
        // query
        $query = "DELETE FROM " . $this->table_name . " WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
  
        // sanitize
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
  
        // bind
        $stmt->bindParam(1, $this->product_id);
  
        // executa
        if($stmt->execute()){
            return true;
        }
        return false;
    }

}

?>