<?php
require_once 'config/database.php';

function getAllTasksByUser($username) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM tasks WHERE username = '$username' ORDER BY deadline ASC";
    return query($query);
}

function getTaskById($id, $username = null) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM tasks WHERE id = $id";
    if ($username) {
        $username = mysqli_real_escape_string($conn, $username);
        $query .= " AND username = '$username'";
    }
    $result = query($query);
    return $result[0] ?? null;
}

function addTask($data, $username) {
    global $conn;
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $deadline = mysqli_real_escape_string($conn, $data['deadline']);
    $status = mysqli_real_escape_string($conn, $data['status']);
    $username = mysqli_real_escape_string($conn, $username);

    $query = "INSERT INTO tasks (title, description, deadline, status, username, created_at) 
              VALUES ('$title', '$description', '$deadline', '$status', '$username', NOW())";
    return mysqli_query($conn, $query);
}

function updateTask($id, $data, $username = null) {
    global $conn;
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $deadline = mysqli_real_escape_string($conn, $data['deadline']);
    $status = mysqli_real_escape_string($conn, $data['status']);
    $id = intval($id);

    if ($username) {
        $username = mysqli_real_escape_string($conn, $username);
        $query = "UPDATE tasks SET 
                    title = '$title', 
                    description = '$description', 
                    deadline = '$deadline', 
                    status = '$status', 
                    updated_at = NOW()
                  WHERE id = $id AND username = '$username'";
    } else {
        $query = "UPDATE tasks SET 
                    title = '$title', 
                    description = '$description', 
                    deadline = '$deadline', 
                    status = '$status', 
                    updated_at = NOW()
                  WHERE id = $id";
    }

    return mysqli_query($conn, $query);
}

function autoCompleteTasks($currentDate, $username) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);

    $query = "UPDATE tasks 
              SET status = 'completed' 
              WHERE deadline <= ? AND status != 'completed' AND username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $currentDate, $username);
    return $stmt->execute();
}

function deleteTask($id, $username = null) {
    global $conn;
    $id = intval($id);
    if ($username) {
        $username = mysqli_real_escape_string($conn, $username);
        $query = "DELETE FROM tasks WHERE id = $id AND username = '$username'";
    } else {
        $query = "DELETE FROM tasks WHERE id = $id";
    }
    return mysqli_query($conn, $query);
}

function updateTaskStatus($id, $status, $username = null) {
    global $conn;
    $id = intval($id);
    $status = mysqli_real_escape_string($conn, $status);

    if ($username) {
        $username = mysqli_real_escape_string($conn, $username);
        $query = "UPDATE tasks SET status = '$status' WHERE id = $id AND username = '$username'";
    } else {
        $query = "UPDATE tasks SET status = '$status' WHERE id = $id";
    }

    return mysqli_query($conn, $query);
}
?>
