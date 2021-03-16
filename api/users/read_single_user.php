<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av product
$user = new User($db);

//Hämta id från url

$user->id = isset($_GET['id']) ? $_GET['id'] : die();

//Hämta user
$user->read_single_user();

//Skapa array med all data
$user_arr = array(
    'userID' => $user->userID,
    'fname' => $user->fname,
    'lname' => $user->lname,
    'username' => $user->username,
    'password' => $user->password,
    'email' => $user->email,
    'created_at' => $user->created_at,
    'role' => $user->role,
);

// Gör till json och skriv ut
print_r(json_encode($user_arr));
