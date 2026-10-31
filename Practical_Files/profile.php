

<?php
require __DIR__ . '/backend/auth.php';
require_login();
require __DIR__ . '/backend/db.php';

// Get the currently logged-in user's ID
$user_id = (int)($_SESSION['user_id'] ?? 0);

// Fetch the student's actual details from MySQL
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

// Use actual registered details
$name = $user['name'];
$enrollment = $user['enrollment'];
$email = $user['email'];
$department = $user['course'];
$semester = $user['semester'];
$phone = $user['phone'];
$gender = $user['gender'];

// Display values safely
function profileText($value) {
    if ($value === null || $value === '') {
        return 'Not provided';
    }

    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Profile avatar
$avatar = 'https://ui-avatars.com/api/?name=' .
          urlencode($name) .
          '&background=0a192f&color=64ffda&size=128';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StudentHub - Profile</title>

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
                Welcome to your StudentHub profile.
            </span>

            <button class="banner-close-btn" aria-label="Dismiss Banner">
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
                    🌙 <span class="d-none d-md-inline ms-1">Dark</span>
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
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="profile.php">Profile</a>
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
                    Profile
                </li>

            </ol>

        </nav>

        <!-- Hero Section -->
        <section class="p-4 p-md-4 mb-4 rounded-3 shadow-sm hero-navy text-center card-hover">

            <h2 class="mb-2">Student Profile</h2>

            <p class="col-lg-9 mx-auto mb-0 text-white-50">
                Manage your personal student details, view your academic information,
                skills, and campus achievements.
            </p>

        </section>

        <!-- Main Grid -->
        <div class="row g-4">

            <!-- Left Content -->
            <div class="col-lg-8">

                <!-- Profile Overview Card -->
                <article class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4 p-md-5 text-center text-md-start">

                        <div class="row align-items-center">

                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">

                                <img src="<?= htmlspecialchars($avatar, ENT_QUOTES, 'UTF-8') ?>"
                                     alt="Student Profile Picture"
                                     class="rounded-circle img-thumbnail shadow-sm"
                                     style="width: 140px; height: 140px; object-fit: cover;">

                            </div>

                            <!-- Student Details -->
                            <div class="col-md-8">

                                <h3 class="text-navy fw-bold mb-1">
                                    <?= profileText($name) ?>
                                </h3>

                                <p class="text-muted mb-2">

                                    <i class="bi bi-card-heading text-accent me-1"></i>

                                    <?= profileText($enrollment) ?>

                                    &bull;

                                    <span class="badge bg-navy">
                                        <?= profileText($department) ?>

                                        <?php if (!empty($semester) && $semester !== 'Not provided'): ?>
                                            (Sem <?= profileText($semester) ?>)
                                        <?php endif; ?>
                                    </span>

                                </p>

                                <p class="text-secondary small mb-3">

                                    <i class="bi bi-envelope text-accent me-1"></i>
                                    <?= profileText($email) ?>

                                    |

                                    <i class="bi bi-telephone text-accent ms-2 me-1"></i>
                                    <?= profileText($phone) ?>

                                </p>

                                <div class="d-flex gap-2 flex-wrap">

                                    <a href="dashboard.php" class="btn btn-sm btn-accent">
                                        <i class="bi bi-speedometer2 me-1"></i>
                                        Go to Dashboard
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-navy"
                                            data-modal-target="#editProfileModal">

                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit Details

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </article>

                <!-- Personal and Academic Information -->
                <section class="card border-0 shadow-sm mb-4 card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-info-circle-fill me-2 text-accent"></i>
                            Personal & Academic Information
                        </h3>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th scope="col" class="text-navy">Field</th>
                                        <th scope="col" class="text-navy">Information</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>
                                        <td class="fw-medium text-secondary">Name</td>
                                        <td class="fw-semibold text-navy">
                                            <?= profileText($name) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Enrollment No.</td>
                                        <td class="text-dark">
                                            <?= profileText($enrollment) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Department / Course</td>
                                        <td class="text-dark">
                                            <?= profileText($department) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Semester</td>
                                        <td class="text-dark">
                                            <?= profileText($semester) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Email</td>
                                        <td class="text-dark">
                                            <?= profileText($email) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Phone</td>
                                        <td class="text-dark">
                                            <?= profileText($phone) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium text-secondary">Gender</td>
                                        <td class="text-dark">
                                            <?= profileText(ucfirst((string)$gender)) ?>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </section>

                <!-- Skills Card -->
                <section class="card border-0 shadow-sm card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-code-slash me-2 text-accent"></i>
                            Skills & Expertise
                        </h3>

                        <p class="text-secondary small">
                            Sample skills displayed for demonstration.
                        </p>

                        <div class="d-flex flex-wrap gap-2">

                            <span class="badge bg-light text-navy border px-3 py-2 fs-6">
                                <i class="bi bi-filetype-java me-1 text-accent"></i>
                                Java Programming
                            </span>

                            <span class="badge bg-light text-navy border px-3 py-2 fs-6">
                                <i class="bi bi-filetype-py me-1 text-accent"></i>
                                Python
                            </span>

                            <span class="badge bg-light text-navy border px-3 py-2 fs-6">
                                <i class="bi bi-filetype-html me-1 text-accent"></i>
                                HTML5
                            </span>

                            <span class="badge bg-light text-navy border px-3 py-2 fs-6">
                                <i class="bi bi-lightbulb me-1 text-accent"></i>
                                Problem Solving
                            </span>

                        </div>

                    </div>

                </section>

            </div>

            <!-- Right Sidebar -->
            <aside class="col-lg-4">

                <!-- Achievements Card -->
                <div class="card border-0 shadow-sm card-hover">

                    <div class="card-body p-4">

                        <h3 class="h5 card-title text-navy fw-bold mb-3">
                            <i class="bi bi-trophy-fill me-2 text-accent"></i>
                            Achievements
                        </h3>

                        <p class="text-secondary small">
                            Sample achievements displayed for demonstration.
                        </p>

                        <ul class="list-group list-group-flush fs-6">

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Completed HTML Practical
                            </li>

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-award-fill text-warning me-2"></i>
                                Participated in Coding Competition
                            </li>

                            <li class="list-group-item bg-transparent text-secondary px-0">
                                <i class="bi bi-people-fill text-navy me-2"></i>
                                Member of AI Club
                            </li>

                        </ul>

                    </div>

                </div>

            </aside>

        </div>

    </main>

    <!-- Edit Profile Modal -->
    <div class="custom-modal" id="editProfileModal" aria-hidden="true">

        <div class="custom-modal-dialog">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">

                <h5 class="m-0 fw-bold text-navy">
                    <i class="bi bi-pencil-square me-2 text-accent"></i>
                    Update Profile Request
                </h5>

                <button type="button"
                        class="btn-close"
                        data-modal-close
                        aria-label="Close Modal">
                </button>

            </div>

            <p class="text-secondary mb-3">
                To request changes to your registered name, phone number,
                or academic department, please contact the campus administrator.
            </p>

            <div class="text-end d-flex justify-content-end gap-2">

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-modal-close>
                    Close
                </button>

                <a href="contact.html" class="btn btn-accent px-3">
                    <i class="bi bi-envelope-fill me-1"></i>
                    Contact Admin
                </a>

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
