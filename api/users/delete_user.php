<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');   // METHOD DELETE
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$user = new User($db);

// Get raw user data

$data = json_decode(file_get_contents("php://input"));

// Sätt det data till user som ska deletas
$user->userID = $data->userID;

//Delete user
if ($user->delete_user()) {
    echo json_encode(
        array('message' => 'user deleted')
    );
} else {
    echo json_encode(
        array('message' => 'user not deleted')
    );
}
