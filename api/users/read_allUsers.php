<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

//Förbered hämtning av post
$user = new User($db);

//Kör query funktionen från user.php
$result = $user->read_users();

//rowcount
$num = $result->rowCount();

//Kolla om det finns users
if ($num > 0) {
    //user array
    $users_arr = array();
    $users_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //Extract gör så att man kan skriva $title direkt istället för $row['title']
        extract($row);

        $user_item = array(
            'userID' => $userID,
            'fname' => $fname,
            'lname' => $lname, 
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'created_at' => $created_at,
            'role' => $role,
        );

        //Pusha till data arrayen
        array_push($users_arr['data'], $user_item);

    }

    // Gör om data till json och output
    echo json_encode($users_arr);
} else {
    // Inga users
    echo json_encode(
        array('message' => 'No users found')
    );

}
