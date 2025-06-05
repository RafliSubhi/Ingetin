<?php
require_once 'config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? null;

function escape($value) {
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}

function getAllEvent() {
    global $conn, $username;
    if (!$username) return [];

    $username = escape($username);
    $query = "SELECT * FROM event WHERE username = '$username' ORDER BY event_time ASC";
    return query($query);
}

function getEventById($id) {
    global $conn, $username;
    if (!$username) return null;

    $id = (int) $id;
    $username = escape($username);
    $query = "SELECT * FROM event WHERE id = $id AND username = '$username'";
    $result = query($query);
    return $result[0] ?? null;
}

function addEvent($data) {
    global $conn, $username;
    if (!$username) return false;

    $title = escape($data['title']);
    $description = escape($data['description']);
    $event_time = escape($data['event_time']);
    $status = escape($data['status']);
    $username = escape($username);

    $query = "INSERT INTO event (title, description, event_time, status, username, created_at) 
              VALUES ('$title', '$description', '$event_time', '$status', '$username', NOW())";
    return mysqli_query($conn, $query);
}

function updateEvent($id, $data) {
    global $conn, $username;
    if (!$username) return false;

    $id = (int) $id;
    $title = escape($data['title']);
    $description = escape($data['description']);
    $event_time = escape($data['event_time']);
    $status = escape($data['status']);
    $username = escape($username);

    $query = "UPDATE event SET 
                title = '$title', 
                description = '$description', 
                event_time = '$event_time', 
                status = '$status', 
                updated_at = NOW() 
              WHERE id = $id AND username = '$username'";
    return mysqli_query($conn, $query);
}

function deleteEvent($id) {
    global $conn, $username;
    if (!$username) return false;

    $id = (int) $id;
    $username = escape($username);
    $query = "DELETE FROM event WHERE id = $id AND username = '$username'";
    return mysqli_query($conn, $query);
}

function updateEventStatus($id, $status) {
    global $conn, $username;
    if (!$username) return false;

    $id = (int) $id;
    $status = escape($status);
    $username = escape($username);
    $query = "UPDATE event SET status = '$status' WHERE id = $id AND username = '$username'";
    return mysqli_query($conn, $query);
}
?>
