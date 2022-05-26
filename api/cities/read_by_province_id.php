<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/City.php';

$database = new Database();
$db = $database->getConnection();
$items = new City($db);
$items->province_id = isset($_GET['province_id']) ? $_GET['province_id'] : die();

$stmt = $items->getCityByProvinceId();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $cityArr = array();
    $cityArr["body"] = array();
    $cityArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $city = array(
            "city_id" => $city_id,
            "province_id" => $province_id,
            "name" => $name
        );
        $cityArr["body"][] = $city;
    }

    echo json_encode($cityArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
