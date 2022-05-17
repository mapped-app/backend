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
$item->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

$item->getSingleUser();

if ($item->user_id != null) {
    $emp_arr = array(
        "user_id" => $item->user_id,
        "name" => $item->name,
        "email" => $item->email,
        "password" => $item->password,
        "phone" => $item->phone,
        "created" => $item->created,
        "is_active" => $item->is_active
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(404);
    echo json_encode("User not found.");
}