<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/SiteVisited.php';

$database = new Database();
$db = $database->getConnection();
$item = new SiteVisited($db);
$item->site_id = isset($_GET['site_id']) ? $_GET['site_id'] : die();

$item->getSiteVisitedBySiteId();

if ($item->site_id != null) {
    $siteVisited_arr = array(
        "travel_id" => $item->travel_id,
        "site_id" => $item->site_id,
        "cost" => $item->cost,
        "rate" => $item->rate
    );

    http_response_code(200);
    echo json_encode($siteVisited_arr);
} else {
    http_response_code(404);
    echo json_encode("Site Visited not found");
}
