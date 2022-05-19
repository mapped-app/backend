<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/City.php';

$database = new Database();
$db = $database->getConnection();
$item = new City($db);
$data = json_decode(file_get_contents("php://input"));

$item->name = $data->name;

if ($item->createCity()) {
    http_response_code(200);

    $item->getCityById();

    echo json_encode(array(
        "status" => "success",
        "message" => "City was created",
        "city_id" => $item->city_id,
        "province_id" => $item->province_id
    ));
} else {
    echo 'City could not be created';
}
