<?php
$conn = new mysqli('localhost', 'root', '', 'rq_todo');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$task_id = $_POST['task_id'];
$is_completed = $_POST['is_completed'];

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE task SET is_completed = ? WHERE id = ?");
$stmt->bind_param("ii", $is_completed, $task_id); // i = integer

if ($stmt->execute()) {
    header("Location: read-todos.php");
    exit();
} else {
    echo "Error updating task: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
