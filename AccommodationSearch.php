<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: StudentLogin.php");
    exit;
}

if (!isset($_SESSION['saved_accommodations'])) {
    $_SESSION['saved_accommodations'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['property_id'])) {
    $property_id = (int)$_POST['property_id'];
    if (!in_array($property_id, $_SESSION['saved_accommodations'])) {
        $_SESSION['saved_accommodations'][] = $property_id;
    }
    echo json_encode(['message' => 'Saved in Saved Accommodations']);
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
$stmt->close();

$student_university = $student['university'];
$city = "";

if (stripos($student_university, "Cape Town") !== false || stripos($student_university, "Cape Peninsula") !== false) {
    $city = "Cape Town";
} elseif (stripos($student_university, "Johannesburg") !== false || stripos($student_university, "Wits") !== false) {
    $city = "Johannesburg";
} elseif (stripos($student_university, "Pretoria") !== false || stripos($student_university, "Tshwane") !== false) {
    $city = "Pretoria";
} elseif (stripos($student_university, "Stellenbosch") !== false) {
    $city = "Stellenbosch";
} elseif (stripos($student_university, "Durban") !== false || stripos($student_university, "KwaZulu") !== false) {
    $city = "Durban";
} else {
    $city = $student_university; 
}

$minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 1000000;

$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'default';
$orderSQL = '';
if ($sortOrder == 'asc') {
    $orderSQL = "ORDER BY price ASC";
} elseif ($sortOrder == 'desc') {
    $orderSQL = "ORDER BY price DESC";
}

$sql_properties = "SELECT * FROM properties WHERE location LIKE ? $orderSQL";
$stmt_prop = $conn->prepare($sql_properties);
$like = "%" . $city . "%";
$stmt_prop->bind_param("s", $like);
$stmt_prop->execute();
$result_properties = $stmt_prop->get_result();
$stmt_prop->close();

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
                    <li class="nav-item"><a href="Student_Dashboard.php" class="text-decoration-none text-white">Dashboard</a></li>
                    <li class="nav-item active"><a href="AccommodationSearch.php" class="text-decoration-none text-white">Accommodation Search</a></li>
                    <li class="nav-item"><a href="SavedAccommodations.php" class="text-decoration-none text-white">Saved Accommodations</a></li>
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
                            <p>Available Properties Near <?php echo htmlspecialchars($student_university); ?>.<br>
                            Browse accommodations suitable for your university location.</p>
                        </div>
                    </div>
                </div>

                <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
                    <input type="number" name="min_price" placeholder="Min Price" value="<?php echo $_GET['min_price'] ?? ''; ?>">
                    <input type="number" name="max_price" placeholder="Max Price" value="<?php echo $_GET['max_price'] ?? ''; ?>">

                    <select name="sort_order">
                        <option value="default">Default</option>
                        <option value="asc" <?php if(isset($_GET['sort_order']) && $_GET['sort_order']=='asc') echo 'selected'; ?>>Price: Low → High</option>
                        <option value="desc" <?php if(isset($_GET['sort_order']) && $_GET['sort_order']=='desc') echo 'selected'; ?>>Price: High → Low</option>
                    </select>

                    <button type="submit" class="btn btn-primary-custom">Apply</button>
                </form>

                <?php if ($result_properties->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($property = $result_properties->fetch_assoc()): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm h-100">
                                    <img src="<?php echo htmlspecialchars($property['image_url']); ?>" 
                                        class="card-img-top" 
                                        alt="<?php echo htmlspecialchars($property['property_name']); ?>" 
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($property['property_name']); ?></h5>
                                        <p class="card-text text-muted mb-1">
                                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['location']); ?>
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Price:</strong> R<?php echo htmlspecialchars($property['price']); ?> / month
                                        </p>
                                        <p class="card-text small"><?php echo htmlspecialchars($property['description']); ?></p>
                                    </div>
                                    <div>
                                        <a href="<?php echo htmlspecialchars($property['google_form_link']); ?>" target="_blank" class="btn btn-primary-custom w-100 mb-1">Apply now</a>
                                        <button class="btn btn-primary-custom w-100 mb-1 save-btn" data-id="<?php echo $property['property_id']; ?>">
                                            <?php echo in_array($property['property_id'], $_SESSION['saved_accommodations']) ? 'Saved' : 'Save'; ?>
                                        </button>
                                        <span class="save-msg text-success small ms-1"></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        No properties found near <?php echo htmlspecialchars($student_university); ?>.
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
    <script>
    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const propertyId = this.dataset.id;
            const msgSpan = this.nextElementSibling;
            const button = this;

            fetch('', { 
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'property_id=' + propertyId
            })
            .then(response => response.json())
            .then(data => {
                msgSpan.textContent = data.message;
                button.textContent = 'Saved';
            })
            .catch(err => {
                msgSpan.textContent = 'Error';
            });
        });
    });
    </script>
</body>
</html>
