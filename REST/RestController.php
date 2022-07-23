<?php

//Adapted from https://phppot.com/php/php-restful-web-service/
require_once("MenuRestHandler.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";

if(isset($_GET["resource"]))
	$resource = $_GET["resource"];
// if(isset($_GET["page_key"]))
// 	$page_key = $_GET["page_key"];
if($method==="GET")
	$page_operation = "list";
if($method==="POST")
	$page_operation = "create";
if($method==="PUT")
	$page_operation = "update";
if($method==="DELETE")
	$page_operation = "delete";


/*
controls the RESTful services
URL mapping
*/


switch($resource){
	case "menu":	
		switch($page_operation){

			case "list":
				// to handle REST Url /menu/list/
				
				//echo "list invoked from menu";
				$menuRestHandler = new MenuRestHandler();
				$result = $menuRestHandler->getAllMenus();
			break;
	
			case "create":
				// to handle REST Url /menu/create/
				//echo "create invoked from menu";
				$menuRestHandler = new MenuRestHandler();
				$menuRestHandler->add();
			break;
		
			case "delete":
				// to handle REST Url /menu/delete/<row_id>
				//echo "delete invoked from menu";
				$menuRestHandler = new MenuRestHandler();
				$result = $menuRestHandler->deleteMenuById();
			break;
		
			case "update":
				//echo "update invoked from menu";
				// to handle REST Url /menu/update/<row_id>
				$menuRestHandler = new MenuRestHandler();
				$menuRestHandler->editMenuById();
			break;
		}
	break;
}	
?>
