<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['full_name'], $_POST['landlord_email'], $_POST['landlord_password'], $_POST['landlord_contact'])) {
        $_SESSION['full_name'] = $_POST['full_name'];
        $_SESSION['landlord_email'] = $_POST['landlord_email'];
        $_SESSION['landlord_password'] = $_POST['landlord_password'];
        $_SESSION['landlord_contact'] = $_POST['landlord_contact'];

        $_SESSION['landlord_id'] = uniqid('landlord_', true);

        header("Location: Landlord_Dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Log in</title>
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
        <form method="POST">
            <div class="text-center mb-4">
                <h3>Login</h3>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" name="full_name" placeholder="Full name" required>
            </div>

            <div class="mb-3">
                <input type="email" class="form-control" name="landlord_email" placeholder="Landlord Email" required>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" name="landlord_password" placeholder="Password" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" name="landlord_contact" placeholder="Contact" required>
            </div>

            <button type="submit" class="btn btn-ghost w-100">Login</button>

            <p class="mt-3 text-center">
                Don't have an account? <a href="LandlordSignup.php">Sign Up</a>
            </p>

            <p class="mt-3 text-center">
                By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy.</a>
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
