<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->title)) {
    $title = $dbconn->real_escape_string($data->title);
    $description = isset($data->description) ? $dbconn->real_escape_string($data->description) : '';
    $event_date = $dbconn->real_escape_string($data->event_date);
    $ticket_price = $dbconn->real_escape_string($data->ticket_price);
    $image_url = isset($data->image_url) ? $dbconn->real_escape_string($data->image_url) : '';

    // Masukkan data mengikut kolum tepat yang wujud di phpMyAdmin
    $sql = "INSERT INTO events (title, description, event_date, ticket_price, image_url) 
            VALUES ('$title', '$description', '$event_date', '$ticket_price', '$image_url')";

    if ($dbconn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Event created successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => $dbconn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}

$dbconn->close();
?>