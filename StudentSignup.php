<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['student_name'] = $_POST['full_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['student_number'] = $_POST['student_number'];
    $_SESSION['password'] = $_POST['password'];

    header("Location: StudentSignup2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="text-center py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fw-bold fs-4">
                <a href="HomePage.html"><img src="images/default.png" class="logo"></a>
            </div>
        </div>
    </header>

    <div class="card container vh-50 d-flex justify-content-center align-items-center" style="width: 700px;">
        <form method="POST" class="w-50">
            <h3 class="mb-3 text-center">Sign up</h3>
            <h3 class="mb-3 text-center">Step 1: Personal Info</h3>

            <input type="text" name="full_name" placeholder="Full Name" class="form-control mb-3" 
                value="<?php echo $_SESSION['student_name'] ?? ''; ?>" required>

            <input type="email" name="email" placeholder="Email" class="form-control mb-3" 
                value="<?php echo $_SESSION['email'] ?? ''; ?>" required>

            <input type="text" name="student_number" placeholder="Student Number" class="form-control mb-3" 
                value="<?php echo $_SESSION['student_number'] ?? ''; ?>" required>

            <input type="password" name="password" placeholder="Password" class="form-control mb-3" 
                value="<?php echo $_SESSION['password'] ?? ''; ?>" required>
                                
            <button type="submit" name="next_step1" class="btn btn-ghost w-100">Next</button>

            <p class="mt-3 text-center">
                Already a user? <a href="StudentLogin.php">Login</a>
            </p>

            <p class="mt-3 text-center">
                By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy.</a>
            </p>
        </form>
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
</body>
</html>