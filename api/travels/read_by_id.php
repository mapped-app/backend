<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Travel.php';

$database = new Database();
$db = $database->getConnection();
$item = new Travel($db);
$item->travel_id = isset($_GET['travel_id']) ? $_GET['travel_id'] : die();

$item->getTravelById();

if ($item->travel_id != null) {
    $travel_arr = array(
        "travel_id" => $item->travel_id,
        "city_id" => $item->city_id,
        "user_id" => $item->user_id,
        "start_date" => $item->start_date,
        "end_date" => $item->end_date,
        "city_origen" => $item->city_origen,
        "transport" => $item->transport,
        "transport_cost" => $item->transport_cost,
        "transport_time" => $item->transport_time,
        "travel_cost" => $item->travel_cost,
        "travel_time" => $item->travel_time
    );

    http_response_code(200);
    echo json_encode($travel_arr);
} else {
    http_response_code(404);
    echo json_encode("Travel not found");
}
