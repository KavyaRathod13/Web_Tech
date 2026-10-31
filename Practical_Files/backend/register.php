
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

// Get registration form data
$name = trim($_POST['name'] ?? '');
$enrollment = trim($_POST['enrollment'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$gender = $_POST['gender'] ?? '';
$course = trim($_POST['course'] ?? '');
$semester = (int)($_POST['semester'] ?? 0);
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

// Validate all registration fields
if (
    strlen($name) < 2 ||
    !preg_match('/^[a-zA-Z0-9-]{5,20}$/', $enrollment) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !preg_match('/^[0-9+ -]{10,16}$/', $phone) ||
    !in_array($gender, ['male', 'female', 'other'], true) ||
    empty($course) ||
    $semester < 1 ||
    $semester > 8 ||
    !preg_match(
        '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/',
        $password
    ) ||
    $password !== $confirm ||
    empty($_POST['terms'])
) {
    header('Location: ../register.html?error=invalid');
    exit;
}

// Check whether enrollment or email already exists
$stmt = $conn->prepare(
    "SELECT id FROM users
     WHERE enrollment = ? OR email = ?
     LIMIT 1"
);

$stmt->bind_param('ss', $enrollment, $email);
$stmt->execute();

$existingUser = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($existingUser) {
    header('Location: ../register.html?error=duplicate');
    exit;
}

// Hash password securely
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    // Start transaction so both tables stay consistent
    $conn->begin_transaction();

    // Insert into users table
    $stmt = $conn->prepare(
        "INSERT INTO users
        (name, enrollment, email, phone, gender,
         course, semester, password_hash, role)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'student')"
    );

    $stmt->bind_param(
        'ssssssis',
        $name,
        $enrollment,
        $email,
        $phone,
        $gender,
        $course,
        $semester,
        $hash
    );

    $stmt->execute();
    $stmt->close();

    // Get newly registered user ID
    $userId = $conn->insert_id;

    // Insert corresponding student record
    $stmt = $conn->prepare(
        "INSERT INTO students
        (user_id, name, email, course)
        VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        'isss',
        $userId,
        $name,
        $email,
        $course
    );

    $stmt->execute();
    $stmt->close();

    // Save both inserts
    $conn->commit();

    // Registration successful
    header('Location: ../login.html?registered=1');
    exit;

} catch (mysqli_sql_exception $e) {

    // Undo partial inserts if anything fails
    $conn->rollback();

    // MySQL duplicate entry error
    if ((int)$e->getCode() === 1062) {
        header('Location: ../register.html?error=duplicate');
        exit;
    }

    // Log unexpected database errors privately
    error_log('StudentHub registration error: ' . $e->getMessage());

    header('Location: ../register.html?error=server');
    exit;
}
?>
