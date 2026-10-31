
<?php
require __DIR__ . '/backend/auth.php';
require_login('admin');

require __DIR__ . '/backend/db.php';

$studentCount = $conn->query('SELECT COUNT(*) c FROM students')->fetch_assoc()['c'];
$eventCount = $conn->query('SELECT COUNT(*) c FROM events')->fetch_assoc()['c'];
$registrationCount = $conn->query('SELECT COUNT(*) c FROM registrations')->fetch_assoc()['c'];
$userCount = $conn->query('SELECT COUNT(*) c FROM users')->fetch_assoc()['c'];

$logs = $conn->query(
    'SELECT action, created_at FROM audit_logs ORDER BY id DESC LIMIT 5'
)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentHub - Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Practical 4 CSS -->
    <link rel="stylesheet" href="css/practical4-interactivity.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Notification Banner -->
    <div class="notification-banner shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-shield-exclamation me-2"></i>
                <strong>Admin Alert:</strong>
                Scheduled portal database maintenance set for Sunday, 02:00 AM.
            </span>
            <button class="banner-close-btn" aria-label="Dismiss Banner">
                &times;
            </button>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-navy py-3 shadow-sm sticky-top">
        <div class="container text-center position-relative">

            <!-- Theme Toggle -->
            <div class="position-absolute top-0 end-0 mt-1 me-2 me-md-0">
                <button class="theme-toggle-btn" type="button">
                    🌙 <span class="d-none d-md-inline ms-1">Dark</span>
                </button>
            </div>

            <!-- Website Title -->
            <h1 class="header-title m-0 pb-2">
                <i class="bi bi-mortarboard-fill me-2 text-accent"></i>
                StudentHub
            </h1>

            <!-- Navigation -->
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

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav text-center gap-lg-1">
                        <li class="nav-item"><a class="nav-link" href="home.php
">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.html">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        <li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
                        <li class="nav-item"><a class="nav-link" href="feedback.html">Feedback</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-4 flex-grow-1">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="home.php
" class="text-decoration-none text-accent fw-semibold">
                        <i class="bi bi-house-door-fill me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-secondary" aria-current="page">
                    Admin
                </li>
            </ol>
        </nav>

        <!-- Hero Section -->
        <section class="p-4 p-md-4 mb-4 rounded-3 shadow-sm hero-navy text-center card-hover">
            <h2 class="mb-2">
                <i class="bi bi-shield-lock-fill me-2 text-accent"></i>
                Admin Panel
            </h2>
            <p class="col-lg-9 mx-auto mb-0 text-white-50">
                The Admin Panel enables authorized administrators to manage student records,
                faculty data, college events, and campus notices securely.
            </p>
        </section>

        <!-- Live Database Statistics -->
        <section class="card border-0 shadow-sm p-4 mb-4">
            <h3 class="h5 text-navy fw-bold">Live Database Statistics</h3>

            <p>
                Students: <strong><?= $studentCount ?></strong>
                &nbsp;
                Events: <strong><?= $eventCount ?></strong>
                &nbsp;
                Users: <strong><?= $userCount ?></strong>
                &nbsp;
                Event Registrations: <strong><?= $registrationCount ?></strong>
            </p>

            <p>
                <a class="btn btn-accent" href="students.php">Student Records</a>
                <a class="btn btn-accent" href="events_manage.php">Event Records</a>
                <a class="btn btn-outline-primary" href="students_ajax.php">AJAX CRUD</a>
                <a class="btn btn-outline-secondary" href="backend/logout.php">Logout</a>
            </p>

            <h4 class="h6">Recent admin actions</h4>
            <ul>
                <?php foreach ($logs as $log): ?>
                    <li>
                        <?= clean($log['action']) ?>
                        (<?= clean($log['created_at']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Main Content Grid -->
        <div class="row g-4">

            <div class="col-lg-8">

                <!-- Admin Tasks -->
                <article class="card border-0 shadow-sm mb-4 card-hover">
                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-sliders me-2 text-accent"></i>
                            Management Tasks
                        </h3>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-navy">Admin Task</th>
                                        <th scope="col" class="text-navy">Description</th>
                                        <th scope="col" class="text-navy text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-navy text-nowrap">
                                            <i class="bi bi-people-fill text-accent me-2"></i>
                                            Manage Students
                                        </td>
                                        <td class="text-secondary">
                                            Add, edit, or remove student records.
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-accent"
                                                    onclick="location.href='students.php'">
                                                Manage
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold text-navy text-nowrap">
                                            <i class="bi bi-person-badge-fill text-accent me-2"></i>
                                            Manage Faculty
                                        </td>
                                        <td class="text-secondary">
                                            Maintain and update faculty information.
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-accent"
                                                    data-modal-target="#adminModal">
                                                Manage
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold text-navy text-nowrap">
                                            <i class="bi bi-calendar-event-fill text-accent me-2"></i>
                                            Manage Events
                                        </td>
                                        <td class="text-secondary">
                                            Create and update college events and schedules.
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-accent"
                                                    onclick="location.href='events_manage.php'">
                                                Manage
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold text-navy text-nowrap">
                                            <i class="bi bi-megaphone-fill text-accent me-2"></i>
                                            Manage Notices
                                        </td>
                                        <td class="text-secondary">
                                            Publish and manage important announcements.
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-accent"
                                                    data-modal-target="#adminModal">
                                                Publish
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold text-navy text-nowrap">
                                            <i class="bi bi-file-earmark-bar-graph-fill text-accent me-2"></i>
                                            Generate Reports
                                        </td>
                                        <td class="text-secondary">
                                            View and download comprehensive student and event reports.
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-accent"
                                                    data-modal-target="#adminModal">
                                                Export
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">
                <div class="card border-0 shadow-sm card-hover">
                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>
                            Admin Notice
                        </h3>

                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-check2-circle text-accent me-2"></i>
                                Keep student and faculty records updated regularly.
                            </li>
                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-check2-circle text-accent me-2"></i>
                                Double-check event dates and venues before publishing.
                            </li>
                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-check2-circle text-accent me-2"></i>
                                Maintain strict data privacy and security guidelines.
                            </li>
                        </ul>

                    </div>
                </div>
            </aside>

        </div>
    </main>

    <!-- Admin Modal -->
    <div class="custom-modal" id="adminModal" aria-hidden="true">
        <div class="custom-modal-dialog">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="m-0 fw-bold text-navy">
                    <i class="bi bi-gear-fill me-2 text-accent"></i>
                    Admin Task Operation
                </h5>
                <button type="button"
                        class="btn-close"
                        data-modal-close
                        aria-label="Close Modal"></button>
            </div>

            <p class="text-secondary mb-3">
                You are about to execute an elevated administrative function.
                Ensure you have proper authorization before proceeding.
            </p>

            <div class="text-end d-flex justify-content-end gap-2">
                <button type="button"
                        class="btn btn-outline-secondary"
                        data-modal-close>
                    Cancel
                </button>
                <button type="button"
                        class="btn btn-accent px-3"
                        data-modal-close>
                    <i class="bi bi-check2-circle me-1"></i>
                    Proceed
                </button>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-navy text-white py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0 text-white-50">
                &copy; 2026 StudentHub. All Rights Reserved.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Practical 4 JS -->
    <script src="js/practical4-interactivity.js"></script>
    <script src="js/studenthub.js"></script>

</body>
</html>
