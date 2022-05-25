<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/BookedStay.php';

$database = new Database();
$db = $database->getConnection();
$item = new BookedStay($db);
$item->stay_id = isset($_GET['stay_id']) ? $_GET['stay_id'] : die();

$item->getBookedStayByStayId();

if ($item->stay_id != null) {
    $bookedStay_arr = array(
        "travel_id" => $item->travel_id,
        "stay_id" => $item->stay_id,
        "cost" => $item->cost,
        "rate" => $item->rate,
    );

    http_response_code(200);
    echo json_encode($bookedStay_arr);
} else {
    http_response_code(404);
    echo json_encode("Booked Stay not found");
}
