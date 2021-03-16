<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$product = new Product($db);

//Hämta id från url

$product->id = isset($_GET['id']) ? $_GET['id'] : die();

//Hämta product
$product->read_single();

//Skapa array med all data
$product_arr = array(
    'id' => $product->id,
    'title' => $product->title,
    'description' => $product->description,
    'imgUrl' => $product->imgUrl,
    'price' => $product->price,
    'category_id' => $product->category_id,
    'category_name' => $product->category_name,
);

// Gör till json och skriv ut
print_r(json_encode($product_arr));
