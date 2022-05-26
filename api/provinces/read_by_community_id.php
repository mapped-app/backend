<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Province.php';

$database = new Database();
$db = $database->getConnection();
$items = new Province($db);
$items->province_id = isset($_GET['community_id']) ? $_GET['community_id'] : die();

$stmt = $items->getProvincesByCommunityId();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $provinceArr = array();
    $provinceArr["body"] = array();
    $provinceArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $province = array(
            "province_id" => $province_id,
            "community_id" => $community_id,
            "name" => $name
        );
        $provinceArr["body"][] = $province;
    }

    echo json_encode($provinceArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
