<?php
session_start();

use Opis\JsonSchema\Schema;
use Opis\JsonSchema\Validator;
use Opis\JsonSchema\Errors\ErrorFormatter;

require '../vendor/autoload.php';
require '../config/db_connect.php';

if(isset($_POST['search']) || isset($_POST['category'])){
  $search = $_POST['search'];
  $category = $_POST['category'];

  $return_array = array("msg"=>"","data"=>"");


  $sql = "SELECT * FROM menu WHERE name LIKE :search AND category LIKE :category ORDER BY category DESC, name ASC";
  $query = $conn->prepare($sql);
  $query->execute([
    ':search' => '%' . $search . '%',
    ':category' => $category
  ]);

  if($query->rowCount() > 0){

    $array_result = $query->fetchAll(PDO::FETCH_ASSOC);
    $return_array['msg'] = "success";
    $return_array['data'] = $array_result;
  }
  else{
    $return_array['msg'] = "error";
    $return_array['data'] = $search;
  }
  
  header('Content-Type: application/json');
  echo json_encode($return_array);
}


function checkImage($img){
    if (file_exists('../images/menu/'.$img)) {
      return $img;
    }else return 'default.jpg';
}
