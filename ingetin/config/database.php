<?php
$host = 'sql302.infinityfree.com';         // MySQL Hostname dari InfinityFree
$username = 'if0_39155967';                // MySQL Username dari InfinityFree
$password = 'ingetin1234';                 // Password MySQL kamu
$database = 'if0_39155967_inget_app';    
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
