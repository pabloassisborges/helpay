<?php
// Report de Erros
ini_set('display_errors', 1);
error_reporting(E_ALL);
  
// URL da homepage
$home_url="http://localhost:8080/api/";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// Número de registros por página (caso em evolução precise de paginação)
$records_per_page = 1000;
  
// Cláusula LIMIT nas queries
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>