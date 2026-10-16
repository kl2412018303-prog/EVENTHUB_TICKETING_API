<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->event_id) && isset($data->status)) {
    $event_id = intval($data->event_id);
    $status = $dbconn->real_escape_string($data->status);

    $sql = "UPDATE events SET status = '$status' WHERE event_id = '$event_id'";

    if ($dbconn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Status updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $dbconn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}

$dbconn->close();
?>