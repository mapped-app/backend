<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/Community.php';

$database = new Database();
$db = $database->getConnection();
$items = new Community($db);

$stmt = $items->getCommunities();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $communityArr = array();
    $communityArr["body"] = array();
    $communityArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $community = array(
            "community_id" => $community_id,
            "name" => $name
        );
        $communityArr["body"][] = $community;
    }

    echo json_encode($communityArr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found")
    );
}
