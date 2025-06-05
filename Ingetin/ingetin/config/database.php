<?php
$host = 'localhost';         // MySQL Hostname dari InfinityFree
$username = 'root';                // MySQL Username dari InfinityFree
$password = '';                 // Password MySQL kamu
$database = 'inget_app';    
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
?>
