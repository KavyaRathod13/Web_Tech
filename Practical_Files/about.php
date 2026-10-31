
<?php
require_once __DIR__ . '/backend/auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StudentHub - About</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- Practical 4 CSS -->
    <link rel="stylesheet" href="css/practical4-interactivity.css">
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

    <!-- Header Section -->
    <header class="bg-navy py-3 shadow-sm sticky-top">

        <div class="container text-center position-relative">

            <!-- Dark/Light Theme Toggle Button -->
            <div class="position-absolute top-0 end-0 mt-1 me-2 me-md-0">

                <button class="theme-toggle-btn" type="button">
                    🌙
                    <span class="d-none d-md-inline ms-1">Dark</span>
                </button>

            </div>

            <!-- Center-aligned Title -->
            <h1 class="header-title m-0 pb-2">
                <i class="bi bi-mortarboard-fill me-2 text-accent"></i>
                StudentHub
            </h1>

            <!-- Shared Role-Based Navbar -->
            <?php require __DIR__ . '/includes/navbar.php'; ?>

        </div>

    </header>

    <!-- Main Content Grid Layout -->
    <main class="container my-4 flex-grow-1">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-3">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="home.php"
                       class="text-decoration-none text-accent fw-semibold">

                        <i class="bi bi-house-door-fill me-1"></i>
                        Home

                    </a>

                </li>

                <li class="breadcrumb-item active text-secondary"
                    aria-current="page">
                    About
                </li>

            </ol>

        </nav>

        <!-- Hero Section -->
        <section class="p-4 p-md-4 mb-4 rounded-3 shadow-sm hero-navy text-center card-hover">

            <h2 class="mb-2">About StudentHub</h2>

            <p class="col-lg-9 mx-auto mb-3">
                StudentHub is a central portal designed to connect
                college students with academic resources, events,
                and essential campus updates.
            </p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">

                <button type="button"
                        class="btn btn-outline-light-custom px-4 py-2 fw-medium"
                        data-modal-target="#aboutModal">

                    <i class="bi bi-info-circle me-1"></i>
                    Platform Details

                </button>

            </div>

        </section>

        <!-- Dynamic Content Slider -->
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

                            <i class="bi bi-bullseye me-2 text-accent"></i>
                            Mission Statement

                        </h4>

                        <p class="text-muted mb-0">
                            Empowering campus learning through direct
                            digital access and active student engagement.
                        </p>

                    </div>

                    <!-- Slide 2 -->
                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">

                            <i class="bi bi-shield-check me-2 text-accent"></i>
                            Core Values

                        </h4>

                        <p class="text-muted mb-0">
                            Accessibility, student-centric design,
                            real-time communication, and reliable information.
                        </p>

                    </div>

                    <!-- Slide 3 -->
                    <div class="slide-item p-4 text-center bg-white">

                        <h4 class="text-navy fw-bold mb-1">

                            <i class="bi bi-gear-fill me-2 text-accent"></i>
                            Technology Stack

                        </h4>

                        <p class="text-muted mb-0">
                            Built using modern HTML5, CSS3, JavaScript ES6+,
                            and responsive Bootstrap frameworks.
                        </p>

                    </div>

                </div>

                <button class="slider-btn slider-btn-next"
                        aria-label="Next Slide">
                    &rang;
                </button>

            </div>

        </section>

        <!-- Grid Row for Main Content and Sidebar -->
        <div class="row g-4">

            <!-- Primary Content Area -->
            <div class="col-lg-8">

                <!-- Overview Card -->
                <article class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-info-circle-fill me-2 text-accent"></i>
                            Overview

                        </h3>

                        <p class="card-text text-secondary mb-3">
                            StudentHub is a simple web portal designed
                            for college students. It provides important
                            academic information and helps students stay
                            connected with college activities.
                        </p>

                        <p class="card-text text-secondary mb-0">
                            Students can register, log in to their account,
                            view their dashboard, check upcoming events,
                            update their profile, and share their feedback
                            through this portal.
                        </p>

                    </div>

                </article>

                <!-- Objectives Card -->
                <section class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-bullseye me-2 text-accent"></i>
                            Objectives

                        </h3>

                        <ul class="list-group list-group-flush fs-6">

                            <li class="list-group-item bg-transparent text-secondary">

                                <i class="bi bi-check-circle-fill me-2 text-navy"></i>
                                Provide easy access to student information.

                            </li>

                            <li class="list-group-item bg-transparent text-secondary">

                                <i class="bi bi-check-circle-fill me-2 text-navy"></i>
                                Display important college notices.

                            </li>

                            <li class="list-group-item bg-transparent text-secondary">

                                <i class="bi bi-check-circle-fill me-2 text-navy"></i>
                                Share details of upcoming events.

                            </li>

                            <li class="list-group-item bg-transparent text-secondary">

                                <i class="bi bi-check-circle-fill me-2 text-navy"></i>
                                Allow students to communicate with the college.

                            </li>

                        </ul>

                    </div>

                </section>

                <!-- Core Features Card -->
                <section class="card border-0 shadow-sm card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-stars me-2 text-accent"></i>
                            Core Features

                        </h3>

                        <div class="row g-2">

                            <!-- Registration -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-person-plus fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Student Registration
                                    </span>

                                </div>

                            </div>

                            <!-- Login -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-shield-lock fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Secure Login
                                    </span>

                                </div>

                            </div>

                            <!-- Dashboard -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-speedometer2 fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Personal Dashboard
                                    </span>

                                </div>

                            </div>

                            <!-- Profile -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-person-badge fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Student Profile
                                    </span>

                                </div>

                            </div>

                            <!-- Events -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-calendar-event fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Event Information
                                    </span>

                                </div>

                            </div>

                            <!-- Feedback -->
                            <div class="col-md-6">

                                <div class="p-3 border rounded bg-light d-flex align-items-center">

                                    <i class="bi bi-chat-square-text fs-4 text-navy me-3"></i>

                                    <span class="fw-medium text-dark">
                                        Feedback System
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">

                <!-- Quick Facts -->
                <div class="card border-0 shadow-sm sticky-lg-top my-sidebar-offset card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">

                            <i class="bi bi-lightning-charge-fill me-2 text-accent"></i>
                            Quick Facts

                        </h3>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">

                                <span class="text-secondary">
                                    Project Name
                                </span>

                                <strong class="text-navy">
                                    StudentHub
                                </strong>

                            </li>

                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">

                                <span class="text-secondary">
                                    Technology
                                </span>

                                <span class="badge bg-navy">
                                    HTML5 & Bootstrap 5
                                </span>

                            </li>

                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">

                                <span class="text-secondary">
                                    Type
                                </span>

                                <strong class="text-navy">
                                    Student Portal
                                </strong>

                            </li>

                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">

                                <span class="text-secondary">
                                    Accessibility
                                </span>

                                <span class="badge bg-success">
                                    Ready
                                </span>

                            </li>

                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">

                                <span class="text-secondary">
                                    Structure
                                </span>

                                <strong class="text-navy">
                                    Semantic HTML
                                </strong>

                            </li>

                        </ul>

                    </div>

                </div>

            </aside>

        </div>

    </main>

    <!-- Interactive About Modal -->
    <div class="custom-modal"
         id="aboutModal"
         aria-hidden="true">

        <div class="custom-modal-dialog">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">

                <h5 class="m-0 fw-bold text-navy">

                    <i class="bi bi-mortarboard-fill me-2 text-accent"></i>
                    About StudentHub System

                </h5>

                <button type="button"
                        class="btn-close"
                        data-modal-close
                        aria-label="Close Modal">
                </button>

            </div>

            <p class="text-secondary mb-3">
                StudentHub is developed to meet Practical 4 DOM
                manipulation standards. It features local persistence
                for theme options, dynamic notifications, modal popups,
                and enhanced accessibility attributes.
            </p>

            <div class="text-end">

                <button type="button"
                        class="btn btn-accent px-4"
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
                &copy; 2026 StudentHub.
                All Rights Reserved.
            </p>

        </div>

    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Practical 4 JS -->
    <script src="js/practical4-interactivity.js"></script>

    <!-- StudentHub JS -->
    <script src="js/studenthub.js"></script>

</body>

</html>
