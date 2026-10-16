<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->event_id)) {
    $event_id = $data->event_id;
    $sql = "DELETE FROM events WHERE event_id = '$event_id'";
    
    if ($dbconn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Event deleted"]);
    } else {
        echo json_encode(["status" => "error", "message" => $dbconn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Event ID required"]);
}

$dbconn->close();
?>