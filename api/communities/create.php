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
$data = json_decode(file_get_contents("php://input"));

$item->name = $data->name;
$item->getCommunityByName();

if ($item->name == $data->name) {
    http_response_code(400);
    echo json_encode(array("message" => "Community already exists"));
} else {
    $item->name = $data->name;

    if ($item->createCommunity()) {
        http_response_code(200);

        $item->getCommunityByName();

        echo json_encode(array(
            "status" => "success",
            "message" => "Community was created",
            "community_id" => $item->community_id,
            "name" => $item->name
        ));
    } else {
        echo 'Community could not be created';
    }
}
