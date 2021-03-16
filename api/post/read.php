<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$post = new Post($db);

//Kör query funktionen från post.php
$result = $post->read();

//rowcount
$num = $result->rowCount();

//Kolla om det finns posts
if ($num > 0) {
    //post array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //Extract gör så att man kan skriva $title direkt istället för $row['title']
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body), // Inbyggd funktion som gör om html till text om det skulle finnas i body
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        );

        //Pusha till data arrayen
        array_push($posts_arr['data'], $post_item);

    }

    // Gör om data till json och output
    echo json_encode($posts_arr);
} else {
    // Inga posts
    echo json_encode(
        array('message' => 'No posts found')
    );

}
