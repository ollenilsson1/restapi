<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../objects/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

//Kör query funktionen från category.php
$result = $category->read();

//rowcount
$num = $result->rowCount();

//Kolla om det finns categorys
if ($num > 0) {
    //category array
    $categories_arr = array();
    $categories_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //Extract gör så att man kan skriva $title direkt istället för $row['title']
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name,
        );

        //Pusha till data arrayen
        array_push($categories_arr['data'], $category_item);
    }

    // Gör om data till json och output
    echo json_encode($categories_arr);
} else {
    echo json_encode(
        array('message' => 'No categories found')
    );

}