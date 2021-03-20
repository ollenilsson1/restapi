<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); // METHOD PUT
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../objects/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$product = new Product($db);

//Hämtar input

$data = json_decode(file_get_contents("php://input"));

//Kolla om id finns annars error, die.
if (isset($data->id)) {
    $product->id = $data->id;
} else {
    echo json_encode(
        array('message' => 'ID not specified')
    );
    die();
}

// Om värdet är satt, kör funktionen.
if (isset($data->title)) {
    $product->title = $data->title;
    $product->updateTitle();
    echo json_encode(
        array('message' => 'Title updated!')
    );
}

if (isset($data->description)) {
    $product->description = $data->description;
    $product->updateDescription();
    echo json_encode(
        array('message' => 'Description updated!')
    );
}

if (isset($data->imgUrl)) {
    $product->imgUrl = $data->imgUrl;
    $product->updateImgUrl();
    echo json_encode(
        array('message' => 'Image-Url updated!')
    );
}

if (isset($data->price)) {
    $product->price = $data->price;
    $product->updatePrice();
    echo json_encode(
        array('message' => 'Price updated!')
    );
}

if (isset($data->category_id)) {
    $product->category_id = $data->category_id;
    $product->updateCategory();
    echo json_encode(
        array('message' => 'Category ID updated!')
    );
}

/* 

// Sätt det data till product som ska uppdateras
$product->id = $data->id;

$product->title = $data->title;
$product->description = $data->description;
$product->imgUrl = $data->imgUrl;
$product->price = $data->price;
$product->category_id = $data->category_id;


Uppdatera product
if ($product->update()) {
    echo json_encode(
        array('message' => 'product Updated')
    );
} else {
    echo json_encode(
        array('message' => 'product not updated')
    );
} */
