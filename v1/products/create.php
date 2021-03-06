<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // POST METHOD
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../objects/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$product = new Product($db);

// Get raw product data

$data = json_decode(file_get_contents("php://input"));

$product->title = $data->title;
$product->description = $data->description;
$product->imgUrl = $data->imgUrl;
$product->price = $data->price;
$product->quantity = $data->quantity;
$product->category_id = $data->category_id;

//Skapa product
if($product->create()){
    echo json_encode(
        array('message' => 'Product created!')
    );
} else {
    echo json_encode(
        array('message' => 'Could not create product')
    );
}

