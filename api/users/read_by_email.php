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
$item->email = isset($_GET['email']) ? $_GET['email'] : die();

$item->getUserByEmail();

if ($item->email != null) {
    $user_arr = array(
        "user_id" => $item->user_id,
        "token" => $item->token,
        "name" => $item->name,
        "email" => $item->email,
        "password" => $item->password,
        "phone" => $item->phone,
        "created_at" => $item->created_at,
        "updated_at" => $item->updated_at,
        "is_active" => $item->is_active
    );

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode("User not found.");
}
