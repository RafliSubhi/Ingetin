<?php
require_once 'config/database.php';

function getAllSavings() {
    global $conn;
    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query = "SELECT * FROM savings WHERE username = '$username' ORDER BY target_date ASC";
    return query($query);
}

function getSavingById($id) {
    global $conn;
    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query = "SELECT * FROM savings WHERE id = $id AND username = '$username'";
    $result = query($query);
    return $result[0] ?? null;
}

function addSaving($data) {
    global $conn;

    $purpose = mysqli_real_escape_string($conn, $data['purpose']);
    $target_amount = floatval($data['target_amount']);
    $current_amount = floatval($data['current_amount']);
    $target_date = mysqli_real_escape_string($conn, $data['target_date']);
    $status = mysqli_real_escape_string($conn, $data['status']);
    $username = mysqli_real_escape_string($conn, $data['username']);

    $query = "INSERT INTO savings (purpose, target_amount, current_amount, target_date, status, username, created_at) 
              VALUES ('$purpose', $target_amount, $current_amount, '$target_date', '$status', '$username', NOW())";

    return mysqli_query($conn, $query);
}

function updateSaving($id, $data) {
    global $conn;
    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $purpose = mysqli_real_escape_string($conn, $data['purpose']);
    $target_amount = mysqli_real_escape_string($conn, $data['target_amount']);
    $current_amount = mysqli_real_escape_string($conn, $data['current_amount']);
    $target_date = mysqli_real_escape_string($conn, $data['target_date']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    $query = "UPDATE savings SET 
                purpose = '$purpose', 
                target_amount = $target_amount, 
                current_amount = $current_amount, 
                target_date = '$target_date', 
                status = '$status',
                updated_at = NOW()
              WHERE id = $id AND username = '$username'";

    return mysqli_query($conn, $query);
}

function deleteSaving($id) {
    global $conn;
    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query = "DELETE FROM savings WHERE id = $id AND username = '$username'";
    return mysqli_query($conn, $query);
}

function addToSaving($id, $amount) {
    global $conn;
    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $amount = floatval($amount);

    $query = "UPDATE savings 
              SET current_amount = current_amount + $amount 
              WHERE id = $id AND username = '$username'";

    return mysqli_query($conn, $query);
}

function getAllSavingsWithStatusUpdate() {
    global $conn;

    if (!isset($_SESSION['username'])) {
        die("User not logged in");
    }

    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query = "SELECT * FROM savings WHERE username = '$username' ORDER BY target_date ASC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $savings = [];
    $idsToUpdate = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['current_amount'] >= $row['target_amount'] && $row['status'] !== 'completed') {
            $idsToUpdate[] = intval($row['id']);
            $row['status'] = 'completed';
        }
        $savings[] = $row;
    }

    if (!empty($idsToUpdate)) {
        $idsStr = implode(',', $idsToUpdate);
        $updateQuery = "UPDATE savings 
                        SET status = 'completed' 
                        WHERE id IN ($idsStr) AND username = '$username'";
        if (!mysqli_query($conn, $updateQuery)) {
            die("Update failed: " . mysqli_error($conn));
        }
    }

    return $savings;
}
?>
