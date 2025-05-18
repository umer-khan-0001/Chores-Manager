<?php
include 'db.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if task ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Task ID is required.");
}

$task_id = $_GET['id'];

// Delete task
$sql = "DELETE FROM tasks WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Error deleting task: " . $conn->error;
}
?>

