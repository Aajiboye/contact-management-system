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
        $index = $_POST['id'];
        deleteContact($index);
        break;
    case 'update':
        $editIndex = $_POST['id'];
        $newName = $_POST['name'];
        $newNumber = $_POST['phone'];
        editContact($editIndex, $newName, $newNumber);
        break;
    case 'search':
        $searchKey = $_POST['keyword'];
        search($searchKey);
        break;
    case 'view':
        viewPhonebook();
        break;
};
