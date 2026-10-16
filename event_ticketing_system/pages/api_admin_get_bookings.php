<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$sql = "SELECT 
            b.booking_id, 
            u.full_name AS customer_name, 
            e.title AS event_title, 
            b.ticket_quantity, 
            b.total_price, 
            b.booking_date 
        FROM bookings b
        LEFT JOIN users u ON b.user_id = u.user_id
        LEFT JOIN events e ON b.event_id = e.event_id
        ORDER BY b.booking_id DESC";

$result = $dbconn->query($sql);
$bookings = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode(["status" => "success", "bookings" => $bookings]);
$dbconn->close();
?>