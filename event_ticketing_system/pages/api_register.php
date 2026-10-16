<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->full_name) || !isset($data->email) || !isset($data->password)) {
    echo json_encode(["error" => "All fields are required"]);
    exit();
}

$full_name = $data->full_name;
$email = $data->email;
$password_hash = password_hash($data->password, PASSWORD_DEFAULT); 
$role = isset($data->role) ? $data->role : 'customer';
$phone = isset($data->phone) ? $data->phone : '';

$check_sql = "SELECT user_id FROM users WHERE email = '$email'";
$check_result = $dbconn->query($check_sql);

if ($check_result->num_rows > 0) {
    echo json_encode(["error" => "Email is already registered"]);
    exit();
}

$sql = "INSERT INTO users (full_name, email, password_hash, role, phone) VALUES ('$full_name', '$email', '$password_hash', '$role', '$phone')";

if ($dbconn->query($sql) === TRUE) {
    echo json_encode([
        "status" => "success",
        "message" => "User successfully registered!"
    ]);
} else {
    echo json_encode([
        "error" => "Failed to register: " . $dbconn->error
    ]);
}

$dbconn->close();
?>