<?php
require 'auth.php'; require_login('admin'); require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
check_token();
$type = $_POST['type'] ?? '';
$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
if (!in_array($type,['student','event']) || !in_array($action,['add','edit','delete'])) { http_response_code(400); exit('Invalid request'); }
$table = $type === 'student' ? 'students' : 'events';
$back = $type === 'student' ? '../students.php' : '../events_manage.php';
if ($action === 'delete') {
    $stmt=$conn->prepare("DELETE FROM $table WHERE id=?"); $stmt->bind_param('i',$id);
} elseif ($type === 'student') {
    $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $course=trim($_POST['course']??'');
    if (!$name || !filter_var($email,FILTER_VALIDATE_EMAIL) || !$course) { header("Location: $back?error=invalid"); exit; }
    if ($action === 'add') {
        $stmt=$conn->prepare('INSERT INTO students(name,email,course) VALUES(?,?,?)');
        $stmt->bind_param('sss',$name,$email,$course);
    } else {
        $stmt=$conn->prepare('UPDATE students SET name=?,email=?,course=? WHERE id=?');
        $stmt->bind_param('sssi',$name,$email,$course,$id);
    }
} else {
    $name=trim($_POST['name']??''); $category=trim($_POST['category']??''); $date=trim($_POST['event_date']??''); $venue=trim($_POST['venue']??'');
    if (!$name || !in_array($category,['Workshop','Competition','Seminar','Other']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) { header("Location: $back?error=invalid"); exit; }
    $poster = null;
    if (!empty($_FILES['poster']['name'])) {
        if ($_FILES['poster']['error'] !== UPLOAD_ERR_OK || $_FILES['poster']['size'] > 2*1024*1024) { header("Location: $back?error=upload"); exit; }
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['poster']['tmp_name']);
        $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime] ?? null;
        if (!$ext || !getimagesize($_FILES['poster']['tmp_name'])) { header("Location: $back?error=upload"); exit; }
        $poster = bin2hex(random_bytes(12)).'.'.$ext;
        if (!move_uploaded_file($_FILES['poster']['tmp_name'],__DIR__.'/../uploads/'.$poster)) { header("Location: $back?error=upload"); exit; }
    }
    if ($action === 'add') {
        $stmt=$conn->prepare('INSERT INTO events(name,category,event_date,venue,poster) VALUES(?,?,?,?,?)');
        $stmt->bind_param('sssss',$name,$category,$date,$venue,$poster);
    } elseif ($poster) {
        $stmt=$conn->prepare('UPDATE events SET name=?,category=?,event_date=?,venue=?,poster=? WHERE id=?');
        $stmt->bind_param('sssssi',$name,$category,$date,$venue,$poster,$id);
    } else {
        $stmt=$conn->prepare('UPDATE events SET name=?,category=?,event_date=?,venue=? WHERE id=?');
        $stmt->bind_param('ssssi',$name,$category,$date,$venue,$id);
    }
}
if (!$stmt->execute()) { header("Location: $back?error=database"); exit; }
audit($conn, ucfirst($action).' '.$type.' #'.($id ?: $conn->insert_id));
header("Location: $back?success=1");
