<?php
session_start();

use Opis\JsonSchema\Schema;
use Opis\JsonSchema\Validator;
use Opis\JsonSchema\Errors\ErrorFormatter;

require '../vendor/autoload.php';
require '../config/db_connect.php';

if(isset($_POST['search']) && isset($_POST['category'])){
  $search = $_POST['search'];
  $category = $_POST['category'];

  $sql = "SELECT * FROM menu WHERE name LIKE :search AND category LIKE :category ORDER BY category DESC, name ASC";
  $query = $conn->prepare($sql);
  $query->execute([
    ':search' => '%' . $search . '%',
    ':category' => $category
  ]);

  if($query->rowCount() > 0){

    // validateMenu($query);

    while ($item=$query->fetch(PDO::FETCH_ASSOC)) {
        echo '
            <div class="col-sm-6 col-md-4 col-lg-3">
              <a href="menu.php?id='.$item['id'].'" class="card-link">
                <div class="card card-shadow">
                  <img
                      src="images/menu/'.checkImage($item['img']).'"
                      class="card-img-top"
                      alt="'.$item['name'].'"
                  />
                  <div class="card-img-overlay">
                    <p class="item-cat">'.$item['category'].'</p>
                  </div>
                  <div class="card-body">
                      <h5 class="card-title">'.$item['name'].'</h5>
                      <p class="card-text mb-2">'.$item['caption'].'</p>
                      <h6 class="price">Rs '.$item['price'].'</h6>

                      <a href="menu.php?id='.$item['id'].'" class="btn btn-primary">
                        Edit <i class="bx bxs-edit pt-2"></i>
                      </a>

                  </div>
                </div>
              </a>
            </div>
        ';
    }
  }
  else{
    echo '<div class="col align-self-center text-center"><p class="msg">No Search Result for: "'.$search.'"</p></div>';
  }
  
}else{
  // order by descending category (z-a) and descending id (most recent to oldest)
  $sql = "SELECT * FROM menu ORDER BY category DESC, name ASC"; 
  $query = $conn->prepare($sql);
  $query->execute();
}



function checkImage($img){
    if (file_exists('../images/menu/'.$img)) {
      return $img;
    }else return 'default.jpg';
}

function validateMenu($query){
    $arrayResult = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode(array('menu'=>$arrayResult), JSON_NUMERIC_CHECK);
    $data = json_decode($json);

    $validator = new Validator();

    $resolver = $validator->resolver();
    $resolver->registerPrefix("http://example.com/","../schema");


    $result = $validator->validate($data,"http://example.com/menu.json");

    if($result->isValid()){
      header('Content-Type: application/json');
      echo $data;
    }
    else{
      print_r((new ErrorFormatter())->format($result->error()));
      header('HTTP/1.1 500 Internal Server Error \n'.$result->error());
      // exit;
    }


}

?>