<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/User.php';

$database = new Database();
$db = $database->getConnection();
$items = new User($db);

$stmt = $items->getUsers();
$itemCount = $stmt->rowCount();

// echo json_encode($itemCount);

if ($itemCount > 0) {
    $userArr = array();
    $userArr["body"] = array();
    $userArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user = array(
            "user_id" => $user_id,
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "phone" => $phone,
            "created" => $created,
            "is_active" => $is_active
        );
        $userArr["body"][] = $user;
    }

    echo json_encode($userArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
