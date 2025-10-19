<?php
    session_start();

    if (!isset($_SESSION['student_number'])) {
        header("Location: StudentLogin.php");
        exit;
    }

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "izikolethu";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $student_number = $_SESSION['student_number'];

    $sql = "SELECT * FROM students WHERE student_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IZOKOLETHU — Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="text-center py-3" id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fw-bold fs-4">
                <a href="HomePage.html"><img src="images/default.png" class="logo"></a>
            </div>
            <form action="logout.php" method="post">
                <button type="submit" class="btn btn-ghost">Logout</button>
            </form>
        </div>
    </header>

    <div class="app">
        <aside class="sidebar">
            <div class="brand">IZOKOLETHU</div>
            <nav>
                <ul>
                    <li class="nav-item active"><a href="Student_Dashboard.php" class="text-decoration-none text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="AccommodationSearch.php" class="text-decoration-none text-white">Accommodation Search</a></li>
                    <li class="nav-item"><a href="SavedAccommodations.php" class="text-decoration-none text-white">Saved Accommodations</a></li>
                    <li class="nav-item"><a href="Payments.php" class="text-decoration-none text-white">Payment</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main">
            <div class="content">
                <div class="card top-card mb-4">
                    <div class="profile-large">
                        <div class="avatar-large">👤</div>
                        <div class="profile-info">
                            <h2>Welcome, <?php echo htmlspecialchars($student['full_name']); ?></h2>
                            <p>Manage your profile information below</p>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <div class="card tabs-card">
                    <div class="tabs mb-3">
                    <button class="tab-btn active" data-tab="personal">Personal Info</button>
                    <button class="tab-btn" data-tab="university">University Info</button>
                    <button class="tab-btn" data-tab="password">Change Password</button>
                    </div>

                    <div class="tab-panel" id="personal">
                        <form method="POST" action="UpdateStudentDashboard.php" class="form-area">
                            <div class="row">
                            <label>Full Name
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>">
                            </label>
                            <label>Email
                                <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">
                            </label>
                            <label>Contact
                                <input type="text" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>">
                            </label>
                            </div>

                            <div class="row">
                            <label>Nationality
                                <input type="text" name="nationality" value="<?php echo htmlspecialchars($student['nationality']); ?>">
                            </label>
                            <label>ID Number
                                <input type="text" name="id_number" value="<?php echo htmlspecialchars($student['id_number']); ?>">
                            </label>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="update_personal" class="btn btn-primary-custom">Save Personal Info</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-panel" id="university" style="display:none;">
                        <form method="POST" action="UpdateStudentDashboard.php" class="form-area">
                            <div class="row">
                            <label>University
                                <input type="text" name="university" value="<?php echo htmlspecialchars($student['university']); ?>">
                            </label>
                            <label>Campus
                                <input type="text" name="campus" value="<?php echo htmlspecialchars($student['campus']); ?>">
                            </label>
                            <label>Student Number
                                <input type="text" name="student_number" value="<?php echo htmlspecialchars($student['student_number']); ?>" readonly>
                            </label>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="update_university" class="btn btn-primary-custom">Save University Info</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-panel" id="password" style="display:none;">
                        <form method="POST" action="UpdateStudentDashboard.php" class="form-area">
                            <div class="row">
                            <label>Current Password
                                <input type="password" name="current_password">
                            </label>
                            <label>New Password
                                <input type="password" name="new_password">
                            </label>
                            <label>Confirm Password
                                <input type="password" name="confirm_password">
                            </label>
                            </div>

                            <div class="form-actions">
                            <button type="submit" name="update_password" class="btn btn-primary-custom">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="py-3 mt-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-bold fs-4">
                    <a><img src="images/default.png" class="logo"></a>
                </div>

                <div>
                    <a href="AboutUs.html" class="me-3 text-decoration-none text-dark">About us</a>
                    <a href="WhatWeOffer.html" class="me-3 text-decoration-none text-dark">What we offer</a>
                    <a href="Landlord.html" class="me-3 text-decoration-none text-dark">Landlord login</a>
                </div>

                <div>
                    <a href="#" class="me-2 text-dark"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-2 text-dark"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-twitter"></i></a>
                </div>
            </div>

            <div class="text-center small text-muted pt-3">
                <p class="mb-0">
                    &copy; 2024 Your Website. All rights reserved. 
                    <a href="#" class="ms-2 text-decoration-none text-muted">Privacy Policy</a>
                    <a href="#" class="ms-2 text-decoration-none text-muted">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.tab-panel');

        tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            panels.forEach(p => p.style.display = 'none');
            document.getElementById(tab.dataset.tab).style.display = 'block';
        });
        });
    </script>
</body>
</html>
