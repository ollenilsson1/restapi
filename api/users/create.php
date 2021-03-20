<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // POST METHOD
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';
error_reporting(E_ALL ^ E_WARNING); // Visar en varning om man inte fyllt i alla fält i create_user

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$user = new User($db);

// Get raw user data

$data = json_decode(file_get_contents("php://input"));

$user->fname = $data->fname;
$user->lname = $data->lname;
$user->username = $data->username;
$user->password = $data->password; 
$user->email = $data->email;

//Skapa user
if ($user->create()) {
    echo json_encode(
        array('message' => 'User created!')
    );
} else {
    echo json_encode(
        array('message' => 'Could not create user')
    );
}
