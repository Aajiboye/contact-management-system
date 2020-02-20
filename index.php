<?php
require __DIR__ . '/vendor/autoload.php';
require 'functions.php';
$action = !empty($_GET['action']) ? $_GET['action'] : '';
$response = [];

//switch statement based on selections
switch ($action) {
    case 'generateurl':
        
        generateUrl();
        break;
    case 'delete':
        
        break;
    case 'update':
        
        break;
    case 'search':
        
        break;
    case 'view':
        
        break;
};
