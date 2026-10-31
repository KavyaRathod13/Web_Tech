
<?php
require_once __DIR__ . '/backend/auth.php';

$isLoggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? '';

$isAdmin = $isLoggedIn && $role === 'admin';
$isStudent = $isLoggedIn && !$isAdmin;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>StudentHub - Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- StudentHub CSS -->
    <link rel="stylesheet"
          href="css/practical4-interactivity.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Notification Banner -->
    <div class="notification-banner shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">

            <span>
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Notice:</strong>
                Registration for Hackathon 2026 is now open!
            </span>

            <button class="banner-close-btn"
                    aria-label="Dismiss Banner">
                &times;
            </button>

        </div>
    </div>

    <!-- Header -->
    <header class="bg-navy py-3 shadow-sm sticky-top">

        <div class="container text-center position-relative">

            <!-- Theme Toggle -->
            <div class="position-absolute top-0 end-0 mt-1 me-2 me-md-0">

                <button class="theme-toggle-btn" type="button">
                    🌙
                    <span class="d-none d-md-inline ms-1">
                        Dark
                    </span>
                </button>

            </div>

            <!-- Website Title -->
            <h1 class="header-title m-0 pb-2">
                <i class="bi bi-mortarboard-fill me-2 text-accent"></i>
                StudentHub
            </h1>

            <!-- Navigation Bar -->
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

                        <!-- Visible to Everyone -->

                        <li class="nav-item">
                            <a class="nav-link active"
                               href="home.php">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="about.php">
                                About
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="events.html">
                                Events
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="contact.html">
                                Contact
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="faq.html">
                                FAQ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="feedback.html">
                                Feedback
                            </a>
                        </li>

                        <!-- Visitor Navigation -->

                        <?php if (!$isLoggedIn): ?>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="register.html">
                                    Register
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="login.html">
                                    Login
                                </a>
                            </li>

                        <!-- Admin Navigation -->

                        <?php elseif ($isAdmin): ?>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="admin.php">
                                    Admin
                                </a>
                            </li>

                        <!-- Student Navigation -->

                        <?php else: ?>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="dashboard.php">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="profile.php">
                                    Profile
                                </a>
                            </li>

                        <?php endif; ?>

                        <!-- Logout for Logged-in Users -->

                        <?php if ($isLoggedIn): ?>

                            <li class="nav-item">
                                <a class="nav-link"
                                   href="backend/logout.php">
                                    Logout
                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>

                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-4 flex-grow-1">

        <!-- Hero Section -->
        <section class="p-4 p-md-4 mb-4 rounded-3 shadow-sm hero-navy text-center card-hover">

            <h2 class="mb-2">
                Welcome to StudentHub
            </h2>

            <p class="col-lg-9 mx-auto mb-3">
                StudentHub is an online platform designed to help
                students stay connected with campus activities,
                academic resources, and important announcements.
            </p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">

                <?php if (!$isLoggedIn): ?>

                    <a href="register.html"
                       class="btn btn-accent px-4 py-2 fw-medium">
                        Get Started
                    </a>

                <?php elseif ($isAdmin): ?>

                    <a href="admin.php"
                       class="btn btn-accent px-4 py-2 fw-medium">
                        Go to Admin
                    </a>

                <?php else: ?>

                    <a href="dashboard.php"
                       class="btn btn-accent px-4 py-2 fw-medium">
                        Go to Dashboard
                    </a>

                <?php endif; ?>

                <a href="about.php"
                   class="btn btn-outline-light-custom px-4 py-2 fw-medium">
                    Learn More
                </a>

                <button type="button"
                        class="btn btn-outline-light-custom px-4 py-2 fw-medium"
                        data-modal-target="#quickInfoModal">

                    <i class="bi bi-lightning-charge me-1"></i>
                    Quick Info

                </button>

            </div>
        </section>

        <!-- Content Slider -->
        <section class="mb-4">

            <div class="slider-container shadow-sm">

                <button class="slider-btn slider-btn-prev"
                        aria-label="Previous Slide">
                    &lang;
                </button>

                <div class="slider-track">

                    <!-- Slide 1 -->
                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-award me-2 text-accent"></i>
                            Academic Excellence
                        </h4>

                        <p class="text-muted mb-0">
                            Access top study materials, syllabus updates,
                            and exam timetables.
                        </p>

                    </div>

                    <!-- Slide 2 -->
                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-people me-2 text-accent"></i>
                            Vibrant Campus Life
                        </h4>

                        <p class="text-muted mb-0">
                            Join student clubs, tech fests, and cultural
                            events happening every week.
                        </p>

                    </div>

                    <!-- Slide 3 -->
                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">
                            <i class="bi bi-briefcase me-2 text-accent"></i>
                            Career Guidance
                        </h4>

                        <p class="text-muted mb-0">
                            Stay notified about campus placements,
                            internships, and skill workshops.
                        </p>

                    </div>

                </div>

                <button class="slider-btn slider-btn-next"
                        aria-label="Next Slide">
                    &rang;
                </button>

            </div>
        </section>

        <!-- Main Content Grid -->
        <div class="row g-4">

            <!-- Main Content -->
            <div class="col-lg-8">

                <!-- Features Card -->
                <section class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-compass me-2 text-accent"></i>
                            What You Will Find Here
                        </h3>

                        <ul class="list-group list-group-flush fs-6">

                            <li class="list-group-item bg-transparent">
                                <i class="bi bi-person-plus-fill me-2 text-navy"></i>
                                Student Registration
                            </li>

                            <li class="list-group-item bg-transparent">
                                <i class="bi bi-speedometer2 me-2 text-navy"></i>
                                Student Login and Dashboard
                            </li>

                            <li class="list-group-item bg-transparent">
                                <i class="bi bi-calendar-event-fill me-2 text-navy"></i>
                                Upcoming Events
                            </li>

                            <li class="list-group-item bg-transparent">
                                <i class="bi bi-megaphone-fill me-2 text-navy"></i>
                                Latest Announcements
                            </li>

                        </ul>

                    </div>
                </section>

                <!-- Announcement Card -->
                <section class="card border-0 shadow-sm card-announcement-orange card-hover">

                    <div class="card-body p-4">

                        <span class="badge bg-orange mb-2 px-3 py-2 fw-semibold">
                            <i class="bi bi-bell-fill me-1"></i>
                            Latest Announcement
                        </span>

                        <article>

                            <h4 class="h5 card-title text-orange fw-bold mb-2">
                                Welcome Freshers!
                            </h4>

                            <p class="card-text text-secondary mb-0">
                                Register on StudentHub to receive updates
                                about workshops, seminars, and college events.
                            </p>

                        </article>

                    </div>
                </section>

            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">

                <!-- Quick Links -->
                <div class="card border-0 shadow-sm sticky-lg-top my-sidebar-offset card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-link-45deg me-2 text-accent"></i>
                            Quick Links
                        </h3>

                        <div class="list-group list-group-flush">

                            <?php if ($isStudent): ?>

                                <a href="profile.php"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent">

                                    Profile
                                    <i class="bi bi-chevron-right text-navy"></i>
                                </a>

                            <?php elseif ($isAdmin): ?>

                                <a href="admin.php"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent">

                                    Admin Dashboard
                                    <i class="bi bi-chevron-right text-navy"></i>
                                </a>

                            <?php endif; ?>

                            <a href="contact.html"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent">

                                Contact
                                <i class="bi bi-chevron-right text-navy"></i>
                            </a>

                            <a href="faq.html"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent">

                                FAQ
                                <i class="bi bi-chevron-right text-navy"></i>
                            </a>

                        </div>

                    </div>
                </div>

                <!-- Key Dates -->
                <div class="card border-0 shadow-sm card-hover mt-4">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-calendar3 me-2 text-accent"></i>
                            Key Dates
                        </h3>

                        <ul class="list-unstyled mb-0">

                            <li class="d-flex align-items-center mb-3">

                                <div class="bg-navy text-white rounded text-center px-2 py-1 me-3 small"
                                     style="min-width: 50px;">

                                    <strong class="d-block">15</strong>
                                    AUG

                                </div>

                                <div>
                                    <h6 class="mb-0 fw-semibold text-navy fs-6">
                                        Hackathon 2026
                                    </h6>

                                    <small class="text-muted">
                                        Main Auditorium
                                    </small>
                                </div>

                            </li>

                            <li class="d-flex align-items-center">

                                <div class="bg-navy text-white rounded text-center px-2 py-1 me-3 small"
                                     style="min-width: 50px;">

                                    <strong class="d-block">22</strong>
                                    AUG

                                </div>

                                <div>
                                    <h6 class="mb-0 fw-semibold text-navy fs-6">
                                        Tech Symposium
                                    </h6>

                                    <small class="text-muted">
                                        Online / Zoom
                                    </small>
                                </div>

                            </li>

                        </ul>

                    </div>
                </div>

            </aside>

        </div>

    </main>

    <!-- Quick Info Modal -->
    <div class="custom-modal"
         id="quickInfoModal"
         aria-hidden="true">

        <div class="custom-modal-dialog">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">

                <h5 class="m-0 fw-bold text-navy">
                    <i class="bi bi-info-circle me-2 text-accent"></i>
                    StudentHub Quick Info
                </h5>

                <button type="button"
                        class="btn-close"
                        data-modal-close
                        aria-label="Close Modal">
                </button>

            </div>

            <p class="text-secondary mb-3">
                Welcome to Practical 4 DOM Interactivity Demo!
                Here you can check announcements, track events,
                dark mode preferences, and explore student
                resources smoothly.
            </p>

            <div class="text-end">

                <button type="button"
                        class="btn btn-accent px-4"
                        data-modal-close>
                    Got It!
                </button>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-navy text-white py-3 mt-auto">

        <div class="container text-center">

            <p class="mb-0 text-white-50">
                &copy; 2026 StudentHub.
                All Rights Reserved.
            </p>

        </div>

    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Practical 4 JS -->
    <script src="js/practical4-interactivity.js"></script>

    <!-- StudentHub JS -->
    <script src="js/studenthub.js"></script>

</body>
</html>
