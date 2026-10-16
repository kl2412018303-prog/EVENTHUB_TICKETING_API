<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->booking_id)) {
    $booking_id = intval($data->booking_id);

    // Padam rekod tempahan berdasarkan booking_id
    $sql = "DELETE FROM bookings WHERE booking_id = '$booking_id'";

    if ($dbconn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Booking deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $dbconn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid booking ID"]);
}

$dbconn->close();
?>