<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // POST METHOD
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../objects/Category.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

$category = new Category($db);

// Hämtar input

$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

//Skapa category
if($category->create()){
    echo json_encode(
        array('message' => 'category created!')
    );
} else {
    echo json_encode(
        array('message' => 'Could not create category')
    );
}