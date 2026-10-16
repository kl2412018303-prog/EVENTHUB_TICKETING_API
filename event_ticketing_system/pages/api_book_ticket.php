<?php
// pages/api_book_ticket.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"), true);

// Terima nama pembolehubah yang pelbagai supaya tidak tersangkut
$userId = $data['user_id'] ?? $data['id'] ?? null;
$eventId = $data['event_id'] ?? null;
$quantity = $data['ticket_quantity'] ?? $data['quantity'] ?? null;
$totalPrice = $data['total_price'] ?? $data['total_amount'] ?? null;

// Jika user_id tiada, gunakan nilai lalai/pencarian automatik dari pangkalan data
if (!$userId) {
    $userRes = $dbconn->query("SELECT user_id FROM users LIMIT 1");
    if ($userRes && $row = $userRes->fetch_assoc()) {
        $userId = $row['user_id'];
    } else {
        $userId = 1; // Fallback ID
    }
}

if (!$eventId || !$quantity || !$totalPrice) {
    echo json_encode([
        "status" => "error",
        "error" => "Incomplete booking details (Event/Qty/Price missing)."
    ]);
    exit();
}

$bookingDate = date('Y-m-d H:i:s');

$sql = "INSERT INTO bookings (user_id, event_id, ticket_quantity, total_price, booking_date) VALUES (?, ?, ?, ?, ?)";
$stmt = $dbconn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "error" => "Prepare failed: " . $dbconn->error]);
    exit();
}

$stmt->bind_param("iiids", $userId, $eventId, $quantity, $totalPrice, $bookingDate);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Booking successful!",
        "booking_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "error" => "Database error: " . $stmt->error
    ]);
}

$stmt->close();
$dbconn->close();
?>