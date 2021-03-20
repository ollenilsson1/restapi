<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../objects/Product.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

$product = new Product($db);

//Kör query funktionen från product.php
$result = $product->read();

//rowcount
$num = $result->rowCount();

//Kolla om det finns products
if ($num > 0) {
    //product array
    $products_arr = array();
    $products_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //Extract gör så att man kan skriva $title direkt istället för $row['title']
        extract($row);

        $product_item = array(
            'id' => $id,
            'title' => $title,
            'description' => html_entity_decode($description), // Inbyggd funktion som gör om html till text om det skulle finnas i body
            'imgUrl' => $imgUrl,
            'price' => $price,
            'category_id' => $category_id,
            'category_name' => $category_name,
        );

        //Pusha till data arrayen
        array_push($products_arr['data'], $product_item);

    }

    // Gör om data till json och output
    echo json_encode($products_arr);
} else {
    // Inga products
    echo json_encode(
        array('message' => 'No products found')
    );

}
