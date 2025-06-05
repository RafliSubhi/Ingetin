<?php
require_once 'config/database.php';

$query = $conn->query("SELECT id, title, event_date, event_time FROM event");
$events = [];

while ($row = $query->fetch_assoc()) {
    $start = $row['event_date'] . 'T' . $row['event_time'];
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $start,
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
