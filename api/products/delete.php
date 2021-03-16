<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$product = new Product($db);

// Get raw product data

$data = json_decode(file_get_contents("php://input"));

// Sätt det data till product som ska deletas
$product->id = $data->id;

//Delete product
if ($product->delete()) {
    echo json_encode(
        array('message' => 'product deleted')
    );
} else {
    echo json_encode(
        array('message' => 'product not deleted')
    );
}
