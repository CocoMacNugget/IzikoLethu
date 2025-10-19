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
    if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);

    $student_number = $_SESSION['student_number'];
    $stmt = $conn->prepare("SELECT full_name FROM students WHERE student_number=?");
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
    <title>Payment Page</title>
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
                        <li class="nav-item"><a href="Student_Dashboard.php" class="text-decoration-none text-white">Dashboard</a></li>
                        <li class="nav-item"><a href="AccommodationSearch.php" class="text-decoration-none text-white">Accommodation Search</a></li>
                        <li class="nav-item"><a href="SavedAccommodations.php" class="text-decoration-none text-white">Saved Accommodations</a></li>
                        <li class="nav-item active"><a href="Payments.php" class="text-decoration-none text-white">Payment</a></li>
                    </ul>
                </nav>
        </aside>
        <main class="main">
            <div class="card top-card mb-4">
                <div class="profile-large">
                    <div class="avatar-large">💳</div>
                    <div class="profile-info">
                    <h2>Hi, <?php echo htmlspecialchars($student['full_name']); ?></h2>
                    <p>Complete your payment below.</p>
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
                <div class="col-9 p-3">
                    <div class="payment-box">
                        <h5>Payment Information</h5>
                        <p>Accommodation:<br>Address:<br>Total Price: RXXXXX,XX</p>

                        <p><strong>Select Payment Method:</strong></p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cardOption" checked>
                            <label class="form-check-label" for="cardOption">Debit/Credit Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="fundedOption">
                            <label class="form-check-label" for="fundedOption">Funded</label>
                        </div>

                        <form id="cardForm" class="mt-3">
                            <input type="text" class="form-control mb-2" placeholder="Name on Card">
                            <input type="text" class="form-control mb-2" placeholder="Card Number">

                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control mb-2" placeholder="MM/YY">
                                </div>
                                <div class="col-6">
                                    <input type="password" class="form-control mb-2" placeholder="CVV">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary-custom">Submit Payment</button>
                                <button type="reset" class="btn btn-ghost">Cancel</button>
                            </div>
                        </form>

                        <form id="fundedForm" class="mt-3 d-none">
                            <input type="text" class="form-control mb-2" placeholder="Your Funder">
                            <input type="file" class="form-control mb-2">
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary-custom">Submit</button>
                                <button type="reset" class="btn btn-ghost">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="py-3 mt-3" id="footer">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cardOption = document.getElementById('cardOption');
        const fundedOption = document.getElementById('fundedOption');
        const cardForm = document.getElementById('cardForm');
        const fundedForm = document.getElementById('fundedForm');

        cardOption.addEventListener('change', () => {
        cardForm.classList.remove('d-none');
        fundedForm.classList.add('d-none');
        });

        fundedOption.addEventListener('change', () => {
        fundedForm.classList.remove('d-none');
        cardForm.classList.add('d-none');
        });
    </script>

</body>
</html>