<?php
require 'auth.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
check_token();
$name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? ''); $message = trim($_POST['message'] ?? '');
if (strlen($name)<2 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($message)<5) { http_response_code(422); echo json_encode(['error'=>'Please enter valid details.']); exit; }
$file = __DIR__.'/../database/contact_messages.csv';
$f = fopen($file,'a');
if (!$f) { http_response_code(500); echo json_encode(['error'=>'Unable to save message.']); exit; }
flock($f, LOCK_EX); fputcsv($f, [date('c'),$name,$email,$message]); flock($f,LOCK_UN); fclose($f);
echo json_encode(['message'=>'Your message was saved successfully.']);
