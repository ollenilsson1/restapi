<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); // METHOD PUT
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$product = new Product($db);

// Get raw producted data

$data = json_decode(file_get_contents("php://input"));

// Sätt det data till product som ska uppdateras
$product->id = $data->id;

$product->title = $data->title;
$product->description = $data->description;
$product->imgUrl = $data->imgUrl;
$product->price = $data->price;
$product->category_id = $data->category_id;

//Uppdatera product
if ($product->update()) {
    echo json_encode(
        array('message' => 'product Updated')
    );
} else {
    echo json_encode(
        array('message' => 'product not updated')
    );
}
