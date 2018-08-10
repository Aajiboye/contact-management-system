<?php
require 'functions.php';
$action=$_GET['action'];
$response=[];

//switch statement based on selections
switch ($action){
	case 'add':
		$name=$_POST['name'];
		$phone=$_POST['phone'];
		addContact($name,$phone);
		break;
	case 'delete':
		$index=$_POST['id'];
		deleteContact($index);
		break;
		case 'update':
		$editIndex=$_POST['id'];
		$newName=$_POST['name'];
		$newNumber=$_POST['phone'];
		editContact($editIndex,$newName,$newNumber);
		break;
	case 'search':
		$searchKey=$_POST['keyword'];
		search($searchKey);
		break;
	case 'view':
	viewPhonebook();
		break;
			};

?>