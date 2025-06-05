<?php
require_once 'config/database.php';
require_once 'function/event.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$username = mysqli_real_escape_string($conn, $username);

$query = "DELETE FROM event WHERE username = '$username'";
mysqli_query($conn, $query);

header('Location: event.php'); // ganti dengan nama file ini jika berbeda
exit;
