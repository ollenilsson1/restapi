<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); // METHOD PUT
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../objects/User.php';

$database = new Database();
$db = $database->connect(); // connect funktionen kommer från Database.php

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->userID)) {
    $user->userID = $data->userID;
} else {
    echo json_encode(
        array('message' => 'ID not specified')
    );
    die();
}

// Om värdet är satt, kör funktionen.
if (isset($data->fname)) {
    $user->fname = $data->fname;
    $user->updateFname();
    echo json_encode(
        array('message' => 'First name updated!')
    );
}
if (isset($data->lname)) {
    $user->lname = $data->lname;
    $user->updateLname();
    echo json_encode(
        array('message' => 'Last name updated!')
    );
}
if (isset($data->username)) {
    $user->username = $data->username;
    $user->updateUsername();
    echo json_encode(
        array('message' => 'Username updated!')
    );
}
if (isset($data->password)) {
    $user->password = $data->password;
    $user->updatePassword();
    echo json_encode(
        array('message' => 'Password updated!')
    );
}
if (isset($data->email)) {
    $user->email = $data->email;
    $user->updateEmail();
    echo json_encode(
        array('message' => 'Email updated!')
    );
}
if (isset($data->role)) {
    $user->role = $data->role;
    $user->updateRole();
    echo json_encode(
        array('message' => 'Role updated!')
    );
}

//Uppdatera product
/* if ($user->updateUser()) {
echo json_encode(
array('message' => 'user Updated')
);
} else {
echo json_encode(
array('message' => 'user not updated')
);
} */
