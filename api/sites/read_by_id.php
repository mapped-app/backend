<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Site.php';

$database = new Database();
$db = $database->getConnection();
$item = new Site($db);
$item->site_id = isset($_GET['site_id']) ? $_GET['site_id'] : die();

$item->getSiteById();

if ($item->site_id != null) {
    $site_arr = array(
        "site_id" => $item->site_id,
        "city_id" => $item->city_id,
        "type" => $item->type,
        "name" => $item->name,
    );

    http_response_code(200);
    echo json_encode($site_arr);
} else {
    http_response_code(404);
    echo json_encode("Site not found");
}
