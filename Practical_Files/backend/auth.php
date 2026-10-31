<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id']) && time() - ($_SESSION['last_activity'] ?? 0) > 1800) {
    $_SESSION = [];
    session_destroy();
    session_start();
}
if (isset($_SESSION['user_id'])) $_SESSION['last_activity'] = time();
function require_login($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: '.(str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/backend/') ? '../login.html?error=login' : 'login.html?error=login')); exit;
    }
    if ($role !== null && ($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403); exit('Access denied: admin only.');
    }
}
function clean($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function check_token() {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403); exit('Invalid request token.');
    }
}
function audit($conn, $action) {
    $uid = $_SESSION['user_id'] ?? null;
    $stmt = $conn->prepare('INSERT INTO audit_logs (user_id, action) VALUES (?, ?)');
    $stmt->bind_param('is', $uid, $action); $stmt->execute();
}
