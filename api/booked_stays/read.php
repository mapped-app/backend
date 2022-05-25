<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/BookedStay.php';

$database = new Database();
$db = $database->getConnection();
$items = new BookedStay($db);

$stmt = $items->getBookedStays();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $bookedStayArr = array();
    $bookedStayArr["body"] = array();
    $bookedStayArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $bookedStay = array(
            "travel_id" => $travel_id,
            "stay_id" => $stay_id,
            "cost" => $cost,
            "rate" => $rate,
        );
        $bookedStayArr["body"][] = $bookedStay;
    }

    echo json_encode($bookedStayArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
