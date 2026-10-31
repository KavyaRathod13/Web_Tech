
<?php

require_once 'auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Invalid request method.'
    ]);
    exit;
}

// Verify CSRF token
check_token();

// Get form data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$rating = trim($_POST['rating'] ?? '');
$comments = trim($_POST['comments'] ?? '');

// Validate name
if (strlen($name) < 2) {
    http_response_code(422);
    echo json_encode([
        'error' => 'Please enter a valid name.'
    ]);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'error' => 'Please enter a valid email address.'
    ]);
    exit;
}

// Validate rating
$allowedRatings = ['excellent', 'good', 'average'];

if (!in_array($rating, $allowedRatings, true)) {
    http_response_code(422);
    echo json_encode([
        'error' => 'Please select a valid rating.'
    ]);
    exit;
}

// Validate comments
if (strlen($comments) < 5) {
    http_response_code(422);
    echo json_encode([
        'error' => 'Comments must contain at least 5 characters.'
    ]);
    exit;
}

// CSV storage location
$directory = __DIR__ . '/../database';
$file = $directory . '/feedback.csv';

// Check database directory
if (!is_dir($directory) || !is_writable($directory)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Feedback storage directory is unavailable.'
    ]);
    exit;
}

// Open CSV file
$f = fopen($file, 'a');

if (!$f) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unable to save feedback.'
    ]);
    exit;
}

// Save feedback safely
if (!flock($f, LOCK_EX)) {
    fclose($f);

    http_response_code(500);
    echo json_encode([
        'error' => 'Unable to lock feedback file.'
    ]);
    exit;
}

$saved = fputcsv($f, [
    date('c'),
    $name,
    $email,
    $rating,
    $comments
]);

fflush($f);
flock($f, LOCK_UN);
fclose($f);

if ($saved === false) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unable to save feedback.'
    ]);
    exit;
}

// Success response
echo json_encode([
    'message' => 'Thank you! Your feedback was submitted successfully.'
]);

?>
