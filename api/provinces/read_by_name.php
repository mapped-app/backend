<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Province.php';

$database = new Database();
$db = $database->getConnection();
$item = new Province($db);
$item->name = isset($_GET['name']) ? $_GET['name'] : die();

$item->getProvinceByName();

if ($item->name != null) {
    $province_arr = array(
        "province_id" => $item->province_id,
        "community_id" => $item->community_id,
        "name" => $item->name
    );

    http_response_code(200);
    echo json_encode($province_arr);
} else {
    http_response_code(404);
    echo json_encode("Province not found");
}
