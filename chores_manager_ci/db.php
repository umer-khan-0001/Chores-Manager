<?php
$host = "db";
$user = "task_user";
$password = "Task@123";
$database = "task_manager";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
