<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Stay.php';

$database = new Database();
$db = $database->getConnection();
$items = new Stay($db);

$stmt = $items->getStays();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $stayArr = array();
    $stayArr["body"] = array();
    $stayArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $stay = array(
            "stay_id" => $stay_id,
            "city_id" => $city_id,
            "category_id" => $category_id,
            "name" => $name
        );
        $stayArr["body"][] = $stay;
    }

    echo json_encode($stayArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
