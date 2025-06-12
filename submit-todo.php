<?php
// Fetch form data
$title = $_POST['todo'];
$description = $_POST['description'];
$due_date = $_POST['due_date'] ?? null;
$is_completed = isset($_POST['is_completed']) ? 1 : 0;
$category_id = (int) $_POST['category_id'];

// Simulated user_id (for demo/testing)


// Database connection
$conn = new mysqli('localhost', 'root', '', 'rq_todo');

// Check for connection error
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    // Prepare the SQL statement (excluding auto-increment id)
    $stmt = $conn->prepare("INSERT INTO task (id, todo, description, due_date, is_completed, category_id) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind the parameters (i = int, s = string)
    $stmt->bind_param("isssii", $user_id, $title, $description, $due_date, $is_completed, $category_id);

    // Execute and check result
    if ($stmt->execute()) {
        echo "Todo added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Clean up
    $stmt->close();
    $conn->close();
}