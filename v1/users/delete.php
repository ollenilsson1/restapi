<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');   // METHOD DELETE
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../objects/User.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$user = new User($db);

//Hämtar input
$data = json_decode(file_get_contents("php://input"));

// Sätt rätt ID till user som ska deletas
$user->userID = $data->userID;

//Delete user
if ($user->delete()) {
    echo json_encode(
        array('message' => 'user deleted')
    );
} else {
    echo json_encode(
        array('message' => 'user not deleted')
    );
}
