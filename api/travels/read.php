<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Travel.php';

$database = new Database();
$db = $database->getConnection();
$items = new Travel($db);

$stmt = $items->getTravels();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $travelArr = array();
    $travelArr["body"] = array();
    $travelArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $travel = array(
            "travel_id" => $travel_id,
            "city_id" => $city_id,
            "user_id" => $user_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "city_origen" => $city_origen,
            "transport" => $transport,
            "transport_cost" => $transport_cost,
            "transport_time" => $transport_time,
            "travel_cost" => $travel_cost,
            "travel_time" => $travel_time
        );
        $travelArr["body"][] = $travel;
    }

    echo json_encode($travelArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
