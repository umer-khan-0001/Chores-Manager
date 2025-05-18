<?php 
include 'db.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION['user_id']; 

// Fetch user's tasks
$sql = "SELECT id, title, description, status FROM tasks WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .task-actions {
            margin-top: 10px;
        }
        .completed {
            color: green;
            font-weight: bold;
        }
        .pending {
            color: Tomato;
            font-weight: bold;
        }
        .complete-btn {
            background: green;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 10px;
        }
        .complete-btn:disabled {
            background: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Task List</h2>
        <a href="add_task.php">Add Task</a> | <a href="logout.php">Logout</a>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong> 
                    (<span class="<?php echo $row['status'] == 'Completed' ? 'completed' : 'pending'; ?>">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </span>)
                    <br>
                    <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                    <div class="task-actions">
                        <a href="edit_task.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="delete_task.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        <?php if ($row['status'] !== 'Completed'): ?>
                            <form action="mark_completed.php" method="POST" style="display:inline;">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="complete-btn">Mark as Completed</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

