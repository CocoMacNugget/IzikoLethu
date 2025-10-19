<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploads = "uploads/";

    $idTmp = $_FILES['id_document']['tmp_name'];
    $idName = basename($_FILES['id_document']['name']);
    $idPath = $uploads . uniqid() . "_" . $idName;

    $proofTmp = $_FILES['proof_of_ownership']['tmp_name'];
    $proofName = basename($_FILES['proof_of_ownership']['name']);
    $proofPath = $uploads . uniqid() . "_" . $proofName;

    if (move_uploaded_file($idTmp, $idPath) && move_uploaded_file($proofTmp, $proofPath)) {
        $_SESSION['id_document'] = $idPath;
        $_SESSION['proof_of_ownership'] = $proofPath;

        header("Location: LandlordSignup4.php");
        exit; 
    }
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
    
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>


    <div class="card container vh-50 d-flex justify-content-center align-items-center" style="width: 700px;">
        <form method="POST" enctype="multipart/form-data" class="w-50">
            <h3 class="mb-3 text-center">Sign up</h3>
            <h3 class="mb-3 text-center">Step 3: Document submissions</h3>

            <div class="form-step">
                <label class="form-label">Upload ID (PDF/JPG/PNG):</label>
                <input type="file" name="id_document" class="form-control mb-3" accept=".pdf,.jpg,.png" required />

                <label class="form-label">Proof of Property Ownership:</label>
                <input type="file" name="proof_of_ownership" class="form-control mb-3" accept=".pdf,.jpg,.png" required />

                <button type="submit" class="btn btn-ghost w-100">Next</button>
                <p class="mt-3 text-center">
                    <a href="StudentSignUp2.php" class="back-link">Back</a>
                </p>
            </div>
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