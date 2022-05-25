<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Site.php';

$database = new Database();
$db = $database->getConnection();
$items = new Site($db);

$stmt = $items->getSites();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $siteArr = array();
    $siteArr["body"] = array();
    $siteArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $site = array(
            "site_id" => $site_id,
            "city_id" => $city_id,
            "type" => $type,
            "name" => $name
        );
        $siteArr["body"][] = $site;
    }

    echo json_encode($siteArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
