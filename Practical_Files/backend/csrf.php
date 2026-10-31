<?php
require 'auth.php';
header('Content-Type: application/json');
echo json_encode(['csrf' => token(), 'logged_in' => isset($_SESSION['user_id']), 'role' => $_SESSION['role'] ?? 'guest', 'name' => $_SESSION['name'] ?? '']);
