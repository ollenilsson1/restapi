<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); // METHOD PUT
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../objects/Category.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$category = new Category($db);

//Hämtar input

$data = json_decode(file_get_contents("php://input"));

//Kolla om id finns annars error, die.
if (isset($data->id)) {
    $category->id = $data->id;
} else {
    echo json_encode(
        array('message' => 'ID not specified')
    );
    die();
}

// Om värdet är satt, kör funktionen.
if (isset($data->name)) {
    $category->name = $data->name;
    $category->update();
    echo json_encode(
        array('message' => 'Category updated!')
    );
}