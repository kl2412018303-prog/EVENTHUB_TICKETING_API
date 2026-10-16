<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('../config/dbconn.php');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["error" => "Invalid User ID."]);
    exit();
}

$sql = "SELECT b.booking_id, b.ticket_quantity, b.total_price, b.booking_date, 
               e.title AS event_title, e.event_date, v.venue_name 
        FROM bookings b
        JOIN events e ON b.event_id = e.event_id
        LEFT JOIN venues v ON e.venue_id = v.venue_id
        WHERE b.user_id = $user_id
        ORDER BY b.booking_date DESC";

$result = $dbconn->query($sql);
$bookings = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "bookings" => $bookings
]);

$dbconn->close();
?>