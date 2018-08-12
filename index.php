<?php
require 'functions.php';
$action = !empty($_GET['action']) ? $_GET['action'] : '';
$response = [];

//switch statement based on selections
switch ($action) {
    case 'add':
        $name = !empty($_POST['name']) ? $_POST['name'] : ''; // Read about ternary operators
        $phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $gender = !empty($_POST['gender']) ? $_POST['gender'] : '';
        $bio = !empty($_POST['bio']) ? $_POST['bio'] : '';
        addContact($name, $phone, $email, $gender, $bio);
        break;
    case 'delete':
        $id = isset($_POST['id']) ? $_POST['id'] : '';;
        deleteContact($id);
        break;
    case 'update':
        $name = !empty($_POST['name']) ? $_POST['name'] : ''; // Read about ternary operators
        $phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $gender = !empty($_POST['gender']) ? $_POST['gender'] : '';
        $bio = !empty($_POST['bio']) ? $_POST['bio'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';

        editContact($id, $name, $phone, $email, $gender, $bio);
        break;
    case 'search':
        $searchKey = $_POST['keyword'];
        search($searchKey);
        break;
    case 'view':
        viewPhonebook();
        break;
};
