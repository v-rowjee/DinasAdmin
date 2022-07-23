<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Menu {
	private $menu = array();
	public function getAllMenu(){
		if(isset($_GET['name'])){
			$name = $_GET['name'];
			$query = 'SELECT * FROM menu WHERE name LIKE "%' .$name. '%"';
		} else {
			$query = 'SELECT * FROM menu';
		}
		$dbcontroller = new DBController();
		$this->menu = $dbcontroller->executeSelectQuery($query);
		return $this->menu;
	}

	public function addMenu(){
		if(isset($_POST['name'])){
			$name = $_POST['name'];
			$caption = "";
			$price = 0;
			$img = "default.jpg";
			$category = "starter";
			
			
			if(isset($_POST['caption'])){
				$caption = $_POST['caption'];
			}
			if(isset($_POST['price'])){
				$price = $_POST['price'];
			}
			if(isset($_POST['img'])){
				$img = $_POST['img'];
			}
			if(isset($_POST['category'])){
				$category = $_POST['category'];
			}	
			
			$query = "INSERT INTO menu (name,caption,price, img, category) values (?,?,?,?,? )";
			$data = [$name, $caption , $price, $img , $category];
			$dbcontroller = new DBController();
			$result = $dbcontroller->executeQuery($query, $data);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}
	
	public function deleteMenu(){
		if(isset($_GET['id'])){
			$menu_id = $_GET['id'];
			$query = 'DELETE FROM menu WHERE id = ?';
			$data = [$menu_id];
			$dbcontroller = new DBController();
			$result = $dbcontroller->executeQuery($query, $data);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}
	
	public function editMenu(){
		if(isset($_POST['name']) && isset($_GET['id'])){
			$name = $_POST['name'];
			$caption = $_POST['caption'];
			$price = $_POST['price'];
			$img = $_POST['img'];
			$category = $_POST['category'];
			$menu_id = $_GET['id'];
			$query = "UPDATE menu SET name = ?, caption = ? , price = ? , img = ? , category = ? WHERE id = ? ";
			$data = [$name, $caption , $price, $img , $category, $menu_id];
			$dbcontroller = new DBController();
			$result= $dbcontroller->executeQuery($query, $data);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
		
	}
	
}
?>