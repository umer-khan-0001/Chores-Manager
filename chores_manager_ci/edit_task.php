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

// Fetch task details
$sql = "SELECT title, description FROM tasks WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Task not found.");
}

$task = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $update_sql = "UPDATE tasks SET title=?, description=? WHERE id=? AND user_id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssii", $title, $description, $task_id, $user_id);

    if ($update_stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating task: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>
        <form method="post">
            <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required><br>
            <textarea name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea><br>
            <button type="submit">Update Task</button>
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

