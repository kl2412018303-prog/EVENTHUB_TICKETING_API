<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

// Tapis supaya hanya event yang berstatus 'Approved' sahaja dipaparkan kepada customer
$sql = "SELECT event_id, title, description, event_date, ticket_price, image_url, status 
        FROM events 
        WHERE status = 'Approved' 
        ORDER BY event_id DESC";

$result = $dbconn->query($sql);
$events = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode(["status" => "success", "events" => $events]);
$dbconn->close();
?>