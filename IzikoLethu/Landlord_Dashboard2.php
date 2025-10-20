<?php
session_start();

$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "izikolethu";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['landlord_email'])) {
    die("Error: Landlord not logged in.");
}

$landlord_email = $_SESSION['landlord_email'];

$sql_landlord = "SELECT landlord_id, full_name FROM landlords WHERE email = ?";
$stmt = $conn->prepare($sql_landlord);
$stmt->bind_param("s", $landlord_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Landlord not found.");
}

$landlord = $result->fetch_assoc();
$landlord_id = $landlord['landlord_id'];
$full_name = $landlord['full_name'];
$stmt->close();

$sql_properties = "SELECT * FROM properties WHERE landlord_id = ?";
$stmt_prop = $conn->prepare($sql_properties);
$stmt_prop->bind_param("i", $landlord_id);
$stmt_prop->execute();
$result_properties = $stmt_prop->get_result();

$conn->close();
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
                    <li class="nav-item"><a href="Landlord_Dashboard.php" class="text-decoration-none text-white">Add Property</a></li>
                    <li class="nav-item active"><a href="Landlord_Dashboard2.php" class="text-decoration-none text-white">View Property</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main">
            <div class="content">
                <div class="card top-card mb-4">
                    <div class="profile-large">
                        <div class="avatar-large">🏠</div>
                        <div class="profile-info">
                            <h2>Hello, <?php echo htmlspecialchars($landlord['full_name']); ?></h2>
                            <p>See your properties below.</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <?php if ($result_properties->num_rows > 0): ?>
                        <?php while ($property = $result_properties->fetch_assoc()): ?>
                            <div class="col-md-4">
                                <div class="property-card card h-100 shadow-sm border-0">
                                    <div class="position-relative">
                                        <img src="<?php echo htmlspecialchars($property['image_url']); ?>" 
                                            class="card-img-top rounded-top" 
                                            alt="<?php echo htmlspecialchars($property['property_name']); ?>">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($property['property_name']); ?></h5>
                                        <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['location']); ?></p>

                                        <p class="card-text mt-2">
                                            <?php echo nl2br(htmlspecialchars($property['description'])); ?>
                                        </p>

                                        <div class="fw-bold text-success mb-3">
                                            R<?php echo number_format($property['price'], 2); ?>/month
                                        </div>
                                        <p class="mb-2">
                                            <a href="<?php echo htmlspecialchars($property['google_form_link']); ?>" target="_blank">Apply Link</a>
                                        </p>
                                        
                                        <div>
                                            <a href="ViewApplications.php?property_id=<?php echo $property['property_id']; ?>" class="btn btn-primary-custom w-100 mb-1">View Applications</a>
                                            <a href="?delete_property_id=<?php echo $property['property_id']; ?>" class="btn btn-primary-custom w-100 mb-1" onclick="return confirm('Are you sure you want to delete this property?');">Delete Property</a>
                                            <a href="EditProperty.php?property_id=<?php echo $property['property_id']; ?>" class="btn btn-primary-custom w-100 mb-1">Change Property Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">No properties available yet.</p>
                    <?php endif; ?>
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

