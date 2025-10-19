<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: StudentLogin.php");
    exit;
}

$saved_ids = $_SESSION['saved_accommodations'] ?? [];
$student_number = $_SESSION['student_number'];

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "izikolethu";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM students WHERE student_number = ?");
$stmt->bind_param("s", $student_number);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

$properties = [];
if (!empty($saved_ids)) {

    $placeholders = implode(',', array_fill(0, count($saved_ids), '?'));
    $types = str_repeat('i', count($saved_ids));

    $sql = "SELECT * FROM properties WHERE property_id IN ($placeholders)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param($types, ...$saved_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Accommodations</title>
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
                    <li class="nav-item active"><a href="SavedAccommodations.php" class="text-decoration-none text-white">Saved Accommodations</a></li>
                    <li class="nav-item"><a href="Payments.php" class="text-decoration-none text-white">Payment</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main">
            <div class="content">
                <div class="card top-card mb-4">
                    <div class="profile-large">
                        <div class="avatar-large">🏠</div>
                        <div class="profile-info">
                            <h2>Hello, <?php echo htmlspecialchars($student['full_name']); ?></h2>
                            <p>Your Saved Accommodations</p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($properties)): ?>
                    <div class="row">
                        <?php foreach ($properties as $property): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="<?php echo htmlspecialchars($property['image_url']); ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($property['property_name']); ?></h5>
                                        <p class="card-text"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['location']); ?></p>
                                        <p class="card-text"><strong>Price:</strong> R<?php echo htmlspecialchars($property['price']); ?> / month</p>
                                        <p class="card-text small"><?php echo htmlspecialchars($property['description']); ?></p>
                                    </div>
                                    <div>
                                        <a href="<?php echo htmlspecialchars($property['google_form_link']); ?>" target="_blank" class="btn btn-primary-custom w-100 mb-1">Apply now</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        You have not saved any accommodations yet.
                    </div>
                <?php endif; ?>
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
</body>
</html>
