<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/Travel.php';

$database = new Database();
$db = $database->getConnection();
$item = new Travel($db);
$data = json_decode(file_get_contents("php://input"));

$item->travel_id = $data->travel_id;
$item->city_id = $data->city_id;
$item->user_id = $data->user_id;
$item->start_date = $data->start_date;
$item->end_date = $data->end_date;
$item->city_origen = $data->city_origen;
$item->transport = $data->transport;
$item->transport_cost = $data->transport_cost;
$item->transport_time = $data->transport_time;
$item->travel_cost = $data->travel_cost;
$item->travel_time = $data->travel_time;

if ($item->createTravel()) {
    http_response_code(200);

    $item->getTravelById();

    echo json_encode(array(
        "status" => "success",
        "message" => "Travel was created",
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
    ));
} else {
    echo 'Travel could not be created';
}
