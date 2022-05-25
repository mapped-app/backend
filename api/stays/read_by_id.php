<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Stay.php';

$database = new Database();
$db = $database->getConnection();
$item = new Stay($db);
$item->stay_id = isset($_GET['stay_id']) ? $_GET['stay_id'] : die();

$item->getStayById();

if ($item->stay_id != null) {
    $stay_arr = array(
        "stay_id" => $item->stay_id,
        "city_id" => $item->city_id,
        "category_id" => $item->category_id,
        "name" => $item->name,
    );

    http_response_code(200);
    echo json_encode($stay_arr);
} else {
    http_response_code(404);
    echo json_encode("Stay not found");
}
