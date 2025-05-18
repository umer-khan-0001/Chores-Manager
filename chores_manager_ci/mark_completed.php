<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    }
}
?>
1~<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    }
}
?>
1~<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    }
}
?>
