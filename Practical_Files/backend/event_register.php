<?php
require 'auth.php'; require_login(); require 'db.php';
if ($_SERVER['REQUEST_METHOD']!=='POST') { http_response_code(405); exit; }
check_token(); $event=(int)($_POST['event_id']??0); $user=$_SESSION['user_id'];
$stmt=$conn->prepare('INSERT IGNORE INTO registrations(user_id,event_id) VALUES(?,?)');
$stmt->bind_param('ii',$user,$event); $stmt->execute();
header('Location: ../events.html?joined=1');
