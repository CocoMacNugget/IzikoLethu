<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['business_name'] = $_POST['business_name'];
    $_SESSION['number_of_properties'] = $_POST['number_of_properties'];

    header("Location: LandlordSignup3.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Sign Up</title>
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
            <h3 class="mb-3 text-center">Step 2: Business Information</h3>

            <input type="text" name="business_name" class="form-control mb-3" placeholder="Business/Agency Name" 
            value="<?php echo $_SESSION['business_name'] ?? ''; ?>" required />

            <input type="number" name="number_of_properties" class="form-control mb-3" placeholder="Number of Properties" 
            value="<?php echo $_SESSION['number_of_properties'] ?? ''; ?>" required />
            
            <button type="submit" class="btn btn-ghost w-100">Next</button>
            <p class="mt-3 text-center">
                <a href="LandlordSignUp.php" class="back-link">Back</a>
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