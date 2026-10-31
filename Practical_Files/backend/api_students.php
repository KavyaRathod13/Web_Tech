<?php
require 'auth.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') { http_response_code(403); header('Content-Type: application/json'); exit(json_encode(['error'=>'Admin login required'])); }
require 'db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($conn->query('SELECT id,name,email,course FROM students ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC)); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
check_token();
$action=$_POST['action']??''; $id=(int)($_POST['id']??0);
if ($action==='delete' && $id>0) {
    $stmt=$conn->prepare('DELETE FROM students WHERE id=?'); $stmt->bind_param('i',$id);
} else {
    $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $course=trim($_POST['course']??'');
    if (!$name || !filter_var($email,FILTER_VALIDATE_EMAIL) || !$course) { http_response_code(422); echo json_encode(['error'=>'Invalid fields']); exit; }
    if ($action==='add') { $stmt=$conn->prepare('INSERT INTO students(name,email,course) VALUES(?,?,?)'); $stmt->bind_param('sss',$name,$email,$course); }
    elseif ($action==='edit' && $id>0) { $stmt=$conn->prepare('UPDATE students SET name=?,email=?,course=? WHERE id=?'); $stmt->bind_param('sssi',$name,$email,$course,$id); }
    else { http_response_code(400); echo json_encode(['error'=>'Invalid action']); exit; }
}
if (!$stmt->execute()) { http_response_code(400); echo json_encode(['error'=>'Database error or duplicate email']); exit; }
audit($conn,'AJAX '.$action.' student');
echo json_encode(['message'=>'Saved']);
