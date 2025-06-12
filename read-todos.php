<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'rq_todo');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch all tasks (no user filtering)
$sql = "SELECT id, todo, description, due_date, is_completed, category_id 
        FROM task 
        ORDER BY due_date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Todo List</title>
</head>
<body>
  <h2>Your Todo List</h2>

  <?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10">
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Due Date</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['todo']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td><?= htmlspecialchars($row['due_date']) ?></td>
          <td><?= htmlspecialchars($row['category_id']) ?></td>
          <td><?= $row['is_completed'] ? "✅ Completed" : "❌ Pending" ?></td>
          <td>
            <!-- Delete Form -->
            <form method="POST" action="delete-task.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
              <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
              <button type="submit">Delete</button>
            </form>

            <!-- Update Form -->
            <form method="POST" action="update.php" style="display:inline;">
              <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
              <input type="hidden" name="is_completed" value="<?= $row['is_completed'] ? 0 : 1 ?>">
              <button type="submit"><?= $row['is_completed'] ? 'Mark as Pending' : 'Mark as Completed' ?></button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
    <a href="add_todo.html">
    <button type="button">➕ Add Task</button>
    </a>

  <?php else: ?>
    <p>No tasks found.</p>
  <?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>
