
<?php
require 'db.php';
require 'auth.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Verify CSRF token
check_token();

// Get login details
$enrollment = trim($_POST['enrollment'] ?? '');
$password = $_POST['password'] ?? '';

// Find user by enrollment number
$stmt = $conn->prepare(
    "SELECT id, name, enrollment, email, phone, gender,
            course, semester, password_hash, role
     FROM users
     WHERE enrollment = ?"
);

$stmt->bind_param('s', $enrollment);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Check enrollment and password
if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../login.html?error=invalid');
    exit;
}

// Create a fresh session after successful login
session_regenerate_id(true);

// Save logged-in user's details in session
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['enrollment'] = $user['enrollment'];
$_SESSION['email'] = $user['email'];
$_SESSION['phone'] = $user['phone'];
$_SESSION['gender'] = $user['gender'];
$_SESSION['course'] = $user['course'];
$_SESSION['semester'] = $user['semester'];
$_SESSION['role'] = $user['role'];
$_SESSION['last_activity'] = time();

// Maintain compatibility with earlier profile code
$_SESSION['mobile'] = $user['phone'];

// Record login activity
audit($conn, 'User logged in');

// Redirect according to role
if ($user['role'] === 'admin') {
    header('Location: ../admin.php');
} else {
    header('Location: ../dashboard.php');
}

exit;
?>
