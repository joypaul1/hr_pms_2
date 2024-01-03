<!-- index.php -->

<?php
$tasks = [];

// Load tasks from file if exists
if (file_exists('tasks.json')) {
    $tasks = json_decode(file_get_contents('tasks.json'), true);
}

// Handle form submission to add new tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        $taskName   = $_POST['task'];
        $taskStatus = 'pending'; // Default status

        $tasks[] = [ 'name' => $taskName, 'status' => $taskStatus ];

        // Save tasks to file
        file_put_contents('tasks.json', json_encode($tasks));

        // Redirect to avoid form resubmission on refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Handle task status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskStatus'])) {
    $taskId = $_POST['taskStatus'];

    if (isset($tasks[$taskId])) {
        $tasks[$taskId]['status'] = ($tasks[$taskId]['status'] === 'pending') ? 'completed' : 'pending';

        // Save tasks to file after status update
        file_put_contents('tasks.json', json_encode($tasks));
    }
}

// Handle clear all tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clearAll'])) {
    $tasks = []; // Empty tasks array

    // Save empty tasks to file
    file_put_contents('tasks.json', json_encode($tasks));

    // Redirect to avoid form resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <!-- Your CSS and JS includes here -->
</head>

<body>
    <div class="card clearfix">
        <div class="header">
            <h3>Today TODO List</h3>
        </div>

        <div class="task-input">
            <i class="fa fa-list" aria-hidden="true"></i>
            <form method="post" action="">
                <input type="text" name="task" placeholder="Add a new task">
            </form>
        </div>

        <div class="controls">
            <div class="filters">
                <span class="btn btn-warning active" id="pending">Pending</span>
                <span class="btn btn-success" id="completed">Completed</span>
            </div>
            <form method="post" action="">
                <button class="clear-btn" name="clearAll">Clear All</button>
            </form>
        </div>

        <ul class="task-box">
            <?php foreach ($tasks as $id => $task): ?>
                <li class="task">
                    <label>
                        <input onclick="updateStatus(this)" type="checkbox" name="taskStatus" value="<?= $id ?>" <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                        <p class="<?= $task['status'] === 'completed' ? 'checked' : '' ?>">
                            <?= $task['name'] ?>
                        </p>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>