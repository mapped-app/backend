<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/City.php';

$database = new Database();
$db = $database->getConnection();
$item = new City($db);
$item->province_id = isset($_GET['province_id']) ? $_GET['province_id'] : die();

$item->getCityByProvinceId();

if ($item->city_id != null) {
    $city_arr = array(
        "city_id" => $item->city_id,
        "province_id" => $item->province_id,
        "name" => $item->name
    );

    http_response_code(200);
    echo json_encode($city_arr);
} else {
    http_response_code(404);
    echo json_encode("City not found");
}
