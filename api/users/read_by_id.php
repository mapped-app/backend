<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/User.php';

$database = new Database();
$db = $database->getConnection();
$item = new User($db);
$item->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

$item->getUserById();

if ($item->user_id != null) {
    $user_arr = array(
        "user_id" => $item->user_id,
        "token" => $item->token,
        "name" => $item->name,
        "email" => $item->email,
        "phone" => $item->phone,
        "created_at" => $item->created_at,
        "updated_at" => $item->updated_at,
        "is_active" => $item->is_active
    );

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode("User not found");
}
