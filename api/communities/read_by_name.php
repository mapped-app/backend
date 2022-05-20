<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/Community.php';

$database = new Database();
$db = $database->getConnection();
$item = new Community($db);
$item->name = isset($_GET['name']) ? $_GET['name'] : die();

$item->getCommunityByName();

if ($item->name != null) {
    $community_arr = array(
        "community_id" => $item->community_id,
        "name" => $item->name
    );

    http_response_code(200);
    echo json_encode($community_arr);
} else {
    http_response_code(404);
    echo json_encode("Community not found");
}
