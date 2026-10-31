
<?php
require_once __DIR__ . '/../backend/auth.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && ($_SESSION['role'] ?? '') === 'admin';

$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');

$links = [
    'home.php' => 'Home',
    'about.php' => 'About',
    'events.html' => 'Events',
    'contact.html' => 'Contact',
    'faq.html' => 'FAQ',
    'feedback.html' => 'Feedback'
];

if (!$isLoggedIn) {
    $links['register.html'] = 'Register';
    $links['login.html'] = 'Login';
} elseif ($isAdmin) {
    $links['admin.php'] = 'Admin';
    $links['backend/logout.php'] = 'Logout';
} else {
    $links['dashboard.php'] = 'Dashboard';
    $links['profile.php'] = 'Profile';
    $links['backend/logout.php'] = 'Logout';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark p-0 justify-content-center">

    <button class="navbar-toggler border-0 my-1"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">

        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center"
         id="navbarNav">

        <ul class="navbar-nav text-center gap-lg-1">

            <?php foreach ($links as $href => $label): ?>

                <li class="nav-item">

                    <a class="nav-link <?= $currentPage === $href ? 'active' : '' ?>"
                       href="<?= htmlspecialchars($href, ENT_QUOTES, 'UTF-8') ?>">

                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>

                    </a>

                </li>

            <?php endforeach; ?>

        </ul>

    </div>
</nav>
