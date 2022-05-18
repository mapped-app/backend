<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/User.php';

$database = new Database();
$db = $database->getConnection();
$item = new User($db);
$data = json_decode(file_get_contents("php://input"));

$item->user_id = substr(md5(rand()), 0, 15);
$item->name = $data->name;
$item->email = $data->email;
$item->password = $data->password;
$item->phone = $data->phone;
$item->is_active = 1;
$item->created = date('Y-m-d H:i:s');

if ($item->createUser()) {
    http_response_code(200);
    echo json_encode(array("message" => "User was created.", "user_id" => $item->user_id));
} else {
    echo 'User could not be created.';
}
