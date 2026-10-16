<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$sql = "SELECT event_id, title, description, event_date, ticket_price, image_url, status 
        FROM events 
        ORDER BY event_id DESC";

$result = $dbconn->query($sql);
$events = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['status'] = !empty($row['status']) ? $row['status'] : 'Pending';
        $row['organiser_name'] = 'Organiser';
        $events[] = $row;
    }
}

echo json_encode(["status" => "success", "events" => $events]);
$dbconn->close();
?>