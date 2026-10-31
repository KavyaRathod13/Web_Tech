<?php
require 'db.php'; header('Content-Type: application/json');
$rows=$conn->query('SELECT id,name,category,DATE_FORMAT(event_date,"%d-%m-%Y") AS date FROM events ORDER BY event_date')->fetch_all(MYSQLI_ASSOC);
echo json_encode($rows);
