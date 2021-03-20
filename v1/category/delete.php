<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');   // METHOD DELETE
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../objects/Category.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php
$category = new Category($db);

//Hämtar input
$data = json_decode(file_get_contents("php://input"));
// Sätt rätt ID till category som ska deletas
$category->id = $data->id;
//Delete category
if ($category->delete()) {
    echo json_encode(
        array('message' => 'category deleted')
    );
} else {
    echo json_encode(
        array('message' => 'category not deleted')
    );
}