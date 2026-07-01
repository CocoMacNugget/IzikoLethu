<?php
session_start();

if (!isset($_SESSION['landlord_email'])) {
    header("Location: LandlordLogin.php");
    exit;
}

$lease_duration = '';
$full_name = '';

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "izikolethu";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql_landlord = "SELECT landlord_id, lease_duration, full_name FROM landlords WHERE email = ?";
$stmt_ld = $conn->prepare($sql_landlord);
$stmt_ld->bind_param("s", $_SESSION['landlord_email']);
$stmt_ld->execute();
$result_ld = $stmt_ld->get_result();
$landlord = $result_ld->fetch_assoc();

$lease_duration = $landlord['lease_duration'];
$full_name = $landlord['full_name'];
$_SESSION['landlord_id'] = $landlord['landlord_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['property_name'] = $_POST['propertyName'];
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['lease_duration'] = $lease_duration;
    $_SESSION['google_form_link'] = $_POST['google_form_link'];

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === 0) {
        $target_dir = "upload/";
        $image_path = $target_dir . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $image_path);
        $_SESSION['image_url'] = $image_path;
    }

    header("Location: Process_LandlordProperty.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IZOKOLETHU — Landlord Dashboard</title>
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
                    <li class="nav-item active"><a href="Landlord_Dashboard.php" class="text-decoration-none text-white">Add Property</a></li>
                    <li class="nav-item"><a href="Landlord_Dashboard2.php" class="text-decoration-none text-white">View Property</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main">
            <div class="content">
            <div class="card top-card mb-4">
                <div class="profile-large">
                    <div class="avatar-large">👤</div>
                    <div class="profile-info">
                        <h2>Welcome, <?php echo htmlspecialchars($landlord['full_name']); ?></h2>
                        <p>Add your property details below.</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="mb-4 fw-semibold">Add Property</h2>
                    <form id="addPropertyForm" class="form-area" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <label>
                                Property Name
                                <input type="text" name="propertyName" placeholder="Enter property name" value="<?php echo $_SESSION['property_name'] ?? ''; ?>" required>
                            </label>
                            <label>
                                Location
                                <input type="text" name="location" placeholder="Enter location" value="<?php echo $_SESSION['location'] ?? ''; ?>" required>
                            </label>
                        </div>
                        <div class="row"> 
                            <label>
                                Price
                                <input type="number" name="price" placeholder="Enter price" value="<?php echo $_SESSION['price'] ?? ''; ?>" required>
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                Description
                                <textarea name="description" rows="4" placeholder="Enter description" required><?= htmlspecialchars($_SESSION['description'] ?? '') ?></textarea>
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                Lease Duration (auto)
                                <input type="text" value="<?= htmlspecialchars($lease_duration) ?>" readonly>
                            </label>
                        </div>
                        <div class="row mb-3">
                            <label>
                                Google Form Link
                                <input type="url" name="google_form_link" placeholder="Enter application form URL" value="<?php echo $_SESSION['google_form_link'] ?? ''; ?>" required>
                            </label>
                        </div>
                        <div class="col-md-12 text-center">
                            <label for="image_url" class="btn btn-ghost">
                                <i class="bi bi-cloud-upload fs-2 text-secondary"></i>
                                <div>Upload Image</div>
                            </label>
                            <input type="file" class="d-none" id="image_url" name="image_url" accept="image/*">
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary-custom px-4">Add Property</button>
                        </div>
                    </form>
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
            <div class="text-center small text-muted">
                <p class="mb-0">&copy; 2024 IzikoLethu. All rights reserved.
                    <a href="#" class="ms-2 text-decoration-none text-muted">Privacy Policy</a>
                    <a href="#" class="ms-2 text-decoration-none text-muted">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
