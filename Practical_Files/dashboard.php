
<?php
require __DIR__ . '/backend/auth.php';
require_login();
require __DIR__ . '/backend/db.php';

// Get logged-in user's ID
$user_id = (int)($_SESSION['user_id'] ?? 0);

// Fetch actual student details from MySQL
$stmt = $conn->prepare(
    "SELECT name, enrollment, email, phone, gender, course, semester
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    http_response_code(403);
    exit("Student record not found. Please log out and log in again.");
}

// Student details from database
$name = $user['name'];
$enrollment = $user['enrollment'];
$email = $user['email'];
$phone = $user['phone'];
$gender = $user['gender'];
$department = $user['course'];
$semester = $user['semester'];

// Academic information is not stored in the current users table
$attendance = 'Not available';
$cgpa = 'Not available';
$pendingTasks = 'Not available';

// Display values safely
function dashboardText($value) {
    if ($value === null || $value === '') {
        return 'Not available';
    }

    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StudentHub - Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Original StudentHub CSS -->
    <link rel="stylesheet" href="css/practical4-interactivity.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Notification Banner -->
    <div class="notification-banner shadow-sm">

        <div class="container d-flex justify-content-between align-items-center">

            <span>
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Notice:</strong>
                Welcome to StudentHub! Check the Events page for campus activities.
            </span>

            <button class="banner-close-btn" aria-label="Dismiss Banner">
                &times;
            </button>

        </div>

    </div>

    <!-- Header -->
    <header class="bg-navy py-3 shadow-sm sticky-top">

        <div class="container text-center position-relative">

            <!-- Dark/Light Theme Toggle -->
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

                        <li class="nav-item">
                            <a class="nav-link" href="home.php
">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="register.html">Register</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="events.html">Events</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="faq.html">FAQ</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="feedback.html">Feedback</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="backend/logout.php">Logout</a>
                        </li>

                    </ul>

                </div>

            </nav>

        </div>

    </header>

    <!-- Main Content -->
    <main class="container my-4 flex-grow-1">

        <!-- Welcome Alert -->
        <div class="alert alert-info">

            Welcome, <?= dashboardText($name) ?>!

            <a href="backend/logout.php">Logout</a>

        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="home.php
" class="text-decoration-none text-accent fw-semibold">

                        <i class="bi bi-house-door-fill me-1"></i>
                        Home

                    </a>

                </li>

                <li class="breadcrumb-item active text-secondary" aria-current="page">
                    Dashboard
                </li>

            </ol>

        </nav>

        <!-- Hero Section -->
        <section class="p-4 p-md-4 mb-4 rounded-3 shadow-sm hero-navy card-hover d-flex align-items-center justify-content-between flex-wrap gap-3">

            <div>

                <h2 class="mb-1">
                    Welcome back, <?= dashboardText($name) ?>!
                </h2>

                <p class="mb-0 text-white-50">
                    Here is a quick overview of your academic information and campus updates.
                </p>

            </div>

            <div class="d-flex gap-2 flex-wrap">

                <button type="button"
                        class="btn btn-outline-light-custom px-3 py-2 text-nowrap"
                        data-modal-target="#reportModal">

                    <i class="bi bi-file-earmark-bar-graph me-1"></i>
                    Academic Report

                </button>

                <a href="profile.php" class="btn btn-accent px-3 py-2 text-nowrap">

                    <i class="bi bi-person-circle me-1"></i>
                    View Profile

                </a>

            </div>

        </section>

        <!-- Interactive Slider -->
        <section class="mb-4">

            <div class="slider-container shadow-sm">

                <button class="slider-btn slider-btn-prev" aria-label="Previous Slide">
                    &lang;
                </button>

                <div class="slider-track">

                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-lightbulb-fill me-2 text-accent"></i>
                            Study Tip
                        </h4>

                        <p class="text-muted mb-0">
                            Maintain regular attendance and complete your practical work on time.
                        </p>

                    </div>

                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-alarm-fill me-2 text-accent"></i>
                            Stay Organized
                        </h4>

                        <p class="text-muted mb-0">
                            Check your course announcements and assignment deadlines regularly.
                        </p>

                    </div>

                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-award-fill me-2 text-accent"></i>
                            Academic Excellence
                        </h4>

                        <p class="text-muted mb-0">
                            Practice programming and revise important concepts consistently.
                        </p>

                    </div>

                </div>

                <button class="slider-btn slider-btn-next" aria-label="Next Slide">
                    &rang;
                </button>

            </div>

        </section>

        <!-- Dashboard Cards -->
        <div class="row g-3 mb-4">

            <!-- Semester -->
            <div class="col-sm-6 col-md-3">

                <div class="card border-0 shadow-sm card-hover h-100">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="rounded-3 bg-light p-3 me-3 text-navy">
                            <i class="bi bi-journal-bookmark fs-3"></i>
                        </div>

                        <div>

                            <span class="text-secondary small d-block">
                                Current Semester
                            </span>

                            <strong class="fs-4 text-navy">

                                <?php if ($semester !== null && $semester !== ''): ?>
                                    Semester <?= dashboardText($semester) ?>
                                <?php else: ?>
                                    Not available
                                <?php endif; ?>

                            </strong>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Attendance -->
            <div class="col-sm-6 col-md-3">

                <div class="card border-0 shadow-sm card-hover h-100">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="rounded-3 bg-light p-3 me-3 text-navy">
                            <i class="bi bi-person-check fs-3"></i>
                        </div>

                        <div>

                            <span class="text-secondary small d-block">
                                Attendance
                            </span>

                            <strong class="fs-5 text-navy">
                                <?= dashboardText($attendance) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CGPA -->
            <div class="col-sm-6 col-md-3">

                <div class="card border-0 shadow-sm card-hover h-100">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="rounded-3 bg-light p-3 me-3 text-navy">
                            <i class="bi bi-award fs-3"></i>
                        </div>

                        <div>

                            <span class="text-secondary small d-block">
                                Current CGPA
                            </span>

                            <strong class="fs-5 text-navy">
                                <?= dashboardText($cgpa) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Pending Tasks -->
            <div class="col-sm-6 col-md-3">

                <div class="card border-0 shadow-sm card-hover h-100">

                    <div class="card-body p-3 d-flex align-items-center">

                        <div class="rounded-3 bg-light p-3 me-3 text-navy">
                            <i class="bi bi-list-task fs-3"></i>
                        </div>

                        <div>

                            <span class="text-secondary small d-block">
                                Pending Tasks
                            </span>

                            <strong class="fs-5 text-navy">
                                <?= dashboardText($pendingTasks) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Main Grid -->
        <div class="row g-4">

            <!-- Academic Details -->
            <div class="col-lg-8">

                <article class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-card-list me-2 text-accent"></i>
                            Academic Details

                        </h3>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th scope="col" class="text-navy">Information</th>
                                        <th scope="col" class="text-navy">Details</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>
                                        <td class="fw-medium text-secondary">Name</td>
                                        <td class="fw-semibold text-navy">
                                            <?= dashboardText($name) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Enrollment Number</td>
                                        <td class="text-dark">
                                            <?= dashboardText($enrollment) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Department / Course</td>
                                        <td class="text-dark">
                                            <?= dashboardText($department) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Semester</td>
                                        <td class="text-dark">
                                            <?= dashboardText($semester) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Email</td>
                                        <td class="text-dark">
                                            <?= dashboardText($email) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Phone</td>
                                        <td class="text-dark">
                                            <?= dashboardText($phone) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Attendance</td>
                                        <td class="text-dark">
                                            <?= dashboardText($attendance) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">CGPA</td>
                                        <td class="text-dark">
                                            <?= dashboardText($cgpa) ?>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </article>

                <!-- Upcoming Assignments -->
                <section class="card border-0 shadow-sm card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-calendar-check me-2 text-accent"></i>
                            Upcoming Assignments

                        </h3>

                        <div class="text-center py-4">

                            <i class="bi bi-calendar2-check fs-1 text-accent"></i>

                            <p class="text-secondary mt-3 mb-0">
                                No assignment records are currently available for your account.
                            </p>

                        </div>

                    </div>

                </section>

            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">

                <!-- Announcements -->
                <div class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-megaphone-fill me-2 text-accent"></i>
                            Announcements

                        </h3>

                        <p class="text-secondary small">
                            General student notices
                        </p>

                        <ul class="list-group list-group-flush fs-6">

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-dot fs-3 text-accent me-1 align-middle"></i>
                                Welcome to StudentHub.
                            </li>

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-dot fs-3 text-accent me-1 align-middle"></i>
                                Check the Events page for campus activities.
                            </li>

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-dot fs-3 text-accent me-1 align-middle"></i>
                                Keep your registration information updated.
                            </li>

                        </ul>

                    </div>

                </div>

                <!-- Quick Links -->
                <div class="card border-0 shadow-sm card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-link-45deg me-2 text-accent"></i>
                            Quick Links

                        </h3>

                        <div class="d-grid gap-2">

                            <a href="profile.php" class="btn btn-outline-navy text-start">

                                <i class="bi bi-person me-2"></i>
                                View Profile

                            </a>

                            <a href="events.html" class="btn btn-outline-navy text-start">

                                <i class="bi bi-calendar-event me-2"></i>
                                Upcoming Events

                            </a>

                            <a href="feedback.html" class="btn btn-outline-navy text-start">

                                <i class="bi bi-chat-square-dots me-2"></i>
                                Give Feedback

                            </a>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </main>

    <!-- Academic Report Modal -->
    <div class="custom-modal" id="reportModal" aria-hidden="true">

        <div class="custom-modal-dialog">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">

                <h5 class="m-0 fw-bold text-navy">

                    <i class="bi bi-file-earmark-pdf-fill me-2 text-accent"></i>
                    Academic Performance Report

                </h5>

                <button type="button"
                        class="btn-close"
                        data-modal-close
                        aria-label="Close Modal">
                </button>

            </div>

            <p class="text-secondary mb-3">
                Your academic report is not currently available.
                Please contact the campus administrator for official academic records.
            </p>

            <div class="text-end">

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-modal-close>
                    Close
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

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Original StudentHub JavaScript -->
    <script src="js/practical4-interactivity.js"></script>
    <script src="js/studenthub.js"></script>

</body>
</html>
