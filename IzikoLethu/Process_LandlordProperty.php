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

if (isset($_SESSION['property_name'], $_SESSION['location'], $_SESSION['price'], $_SESSION['description'],
          $_SESSION['image_url'], $_SESSION['google_form_link'])) {

    $property_name = $_SESSION['property_name'];
    $location = $_SESSION['location']; 
    $price = $_SESSION['price'];
    $description = $_SESSION['description'];
    $image = $_SESSION['image_url'];
    $application_link = $_SESSION['google_form_link'];

    if (!isset($_SESSION['landlord_email'])) {
        die("Error: Landlord not logged in.");
    }

    $landlord_email = $_SESSION['landlord_email'];

    $sql_landlord = "SELECT landlord_id, lease_duration FROM landlords WHERE email = ?";
    $stmt_ld = $conn->prepare($sql_landlord);
    $stmt_ld->bind_param("s", $landlord_email);
    $stmt_ld->execute();
    $result_ld = $stmt_ld->get_result();

    if ($result_ld->num_rows === 0) {
        die("Error: Landlord not found.");
    }

    $landlord = $result_ld->fetch_assoc();
    $landlord_id = $landlord['landlord_id'];
    $lease_duration = $landlord['lease_duration'];
    $stmt_ld->close();

    $sql = "INSERT INTO properties 
            (landlord_id, property_name, location, price, description, lease_duration, image_url, google_form_link)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdssss", $landlord_id, $property_name, $location, $price, $description, $lease_duration, $image, $application_link);

    if ($stmt->execute()) {
        echo "Property added successfully!";
        header("Location: Landlord_Dashboard2.php");
    } else {
        echo "Error inserting property: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Missing property information.";
}

$conn->close();
?>
