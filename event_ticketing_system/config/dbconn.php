<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "event_ticketing_db";
$dbconn = new mysqli($host, $user, $password, $database);

if ($dbconn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $dbconn->connect_error]));
}
?>
