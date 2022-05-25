<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/SiteVisited.php';

$database = new Database();
$db = $database->getConnection();
$items = new SiteVisited($db);

$stmt = $items->getSitesVisited();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $siteVisitedArr = array();
    $siteVisitedArr["body"] = array();
    $siteVisitedArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $siteVisited = array(
            "travel_id" => $travel_id,
            "site_id" => $site_id,
            "cost" => $cost,
            "rate" => $rate
        );
        $siteVisitedArr["body"][] = $siteVisited;
    }

    echo json_encode($siteVisitedArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
