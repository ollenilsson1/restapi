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
$result = $user->read();

//rowcount
$num = $result->rowCount();

//Kolla om det finns users
if ($num > 0) {
    //users array
    $users_arr = array();
    $users_arr['data'] = array();        //Gör en array i users_arr som heter data

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //Extract gör så att man kan skriva $userID direkt istället för $row['userID']
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
