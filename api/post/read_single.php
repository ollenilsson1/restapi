<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$post = new Post($db);

//Hämta id från url

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Hämta post
$post->read_single();

//Skapa array med all data
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
);

// Gör till json
print_r(json_encode($post_arr));
