<?php
session_start();
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "smartpath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentUsername = $_SESSION["username"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        $newTask = trim($_POST['task']);
        if (!empty($newTask)) {
            $stmt = $conn->prepare("INSERT INTO todos(username, tasks, completed) VALUES(?, ?, 0);");
            $stmt->bind_param("ss", $currentUsername, $newTask);
            $stmt->execute();
            $stmt->close();
        }
    } elseif (isset($_POST['delete_task'])) {
        $taskId = intval($_POST['task_id']);
        $stmt = $conn->prepare("DELETE FROM todos WHERE id=? AND username = ?");
        $stmt->bind_param("is", $taskId, $currentUsername);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['toggle_complete'])) {
        $taskId = intval($_POST['task_id']);
        $currentStatus = intval($_POST['current_status']);
        $newStatus = $currentStatus ? 0 : 1; 
        $stmt = $conn->prepare("UPDATE todos SET completed = ? WHERE id = ? AND username = ?");
        $stmt->bind_param("iis", $newStatus, $taskId, $currentUsername);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch tasks for the current user
$stmt = $conn->prepare("SELECT id, tasks, completed FROM todos WHERE username = ?");
$stmt->bind_param("s", $currentUsername);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!$tasks) {
    $tasks = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: darkgreen;
        }

        .task-list {
            margin-top: 20px;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            background-color: #1e1e1e;
            padding: 10px;
            border-radius: 5px;
        }

        .task-item span {
            flex: 1;
        }

        .task-item span.completed {
            text-decoration: line-through;
            color: gray;
        }

        input[type="text"] {
            width: 80%;
            padding: 8px;
            background-color: #1e1e1e;
            border: 1px solid darkgreen;
            color: #ffffff;
            border-radius: 5px;
        }

        button {
            padding: 8px 12px;
            cursor: pointer;
            background-color: darkgreen;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        button:hover {
            background-color: darkgreen;
            opacity: 0.5;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>To-Do List</h1>
    
    <form method="POST" style="text-align: center;">
        <input type="text" name="task" placeholder="Enter a new task..." required>
        <button type="submit" name="add_task">Add Task</button>
    </form>
    
    <div class="task-list">
        <?php if (empty($tasks)): ?>
            <p>No tasks yet. Add a new task!</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li class="task-item">
                        <span class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
                            <?php echo htmlspecialchars($task['tasks']); ?>
                        </span>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $task['completed']; ?>">
                            <button type="submit" name="toggle_complete">
                                <?php echo $task['completed'] ? 'Mark Incomplete' : 'Mark Complete'; ?>
                            </button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" name="delete_task">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>

