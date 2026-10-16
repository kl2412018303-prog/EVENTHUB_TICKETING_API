<?php
header("Content-Type: application/json");
include('../config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->email) || !isset($data->password)) {
    echo json_encode(["error" => "Email and password required"]);
    exit();
}

$email = $data->email;
$password = $data->password;

$sql = "SELECT user_id, full_name, email, password_hash, role FROM users WHERE email = '$email'";
$result = $dbconn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password_hash'])) {
        unset($user['password_hash']);
        
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "user" => $user
        ]);
    } else {
        echo json_encode(["error" => "Invalid email or password"]);
    }
} else {
    echo json_encode(["error" => "Invalid email or password"]);
}

$dbconn->close();
?>