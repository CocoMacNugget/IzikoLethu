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

if (isset($_SESSION['full_name'], $_SESSION['landlord_email'], $_SESSION['landlord_password'], $_SESSION['landlord_contact'],
          $_SESSION['business_name'], $_SESSION['number_of_properties'], $_SESSION['id_document'],
          $_SESSION['proof_of_ownership'], $_SESSION['preferred_student_type'], $_SESSION['lease_duration'])) {

    $full_name = $_SESSION['full_name'];
    $email = $_SESSION['landlord_email'];
    $password = $_SESSION['landlord_password']; 
    $contact = $_SESSION['landlord_contact'];
    $businessName = $_SESSION['business_name'];
    $nrOfProperties = $_SESSION['number_of_properties'];
    $id_document = $_SESSION['id_document'];
    $proofOfOwnership = $_SESSION['proof_of_ownership'];
    $preferredStudentType = $_SESSION['preferred_student_type'];
    $lease_duration = $_SESSION['lease_duration'];

    $sql = "INSERT INTO landlords 
            (full_name, email, password, contact, business_name, number_of_properties, id_document, proof_of_ownership, 
            preferred_student_type, lease_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssissss", $full_name, $email, $password, $contact, $businessName, $nrOfProperties, $id_document, $proofOfOwnership, $preferredStudentType, $lease_duration);

    if ($stmt->execute()) {
        echo "Signup successful!";
        session_destroy();
        header("Location: Landlord_Dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Missing signup information.";
}

$conn->close();
?>