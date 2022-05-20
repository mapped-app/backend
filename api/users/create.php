<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/User.php';

$database = new Database();
$db = $database->getConnection();
$item = new User($db);
$data = json_decode(file_get_contents("php://input"));

$item->email = $data->email;
$item->getUserByEmail();

if ($item->email == $data->email) {
    http_response_code(400);
    echo json_encode(array("message" => "Email already exists"));
} else {
    $item->token = substr(md5(rand()), 0, 15);
    $item->name = $data->name;
    $item->email = $data->email;
    $item->password = $data->password;
    $item->phone = $data->phone;
    $item->is_active = 1;

    if ($item->createUser()) {
        http_response_code(200);

        $item->getUserByEmail();

        echo json_encode(array(
            "status" => "success",
            "message" => "User was created",
            "user_id" => $item->user_id,
            "token" => $item->token
        ));
    } else {
        echo 'User could not be created';
    }
}
