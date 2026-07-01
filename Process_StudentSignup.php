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

if (isset($_SESSION['student_name'], $_SESSION['email'], $_SESSION['student_number'], $_SESSION['password'],
          $_SESSION['contact'], $_SESSION['nationality'], $_SESSION['id_number'],
          $_SESSION['university'], $_SESSION['campus'])) {

    $full_name = $_SESSION['student_name'];
    $email = $_SESSION['email'];
    $student_number = $_SESSION['student_number'];
    $password = $_SESSION['password']; 
    $contact = $_SESSION['contact'];
    $nationality = $_SESSION['nationality'];
    $id_number = $_SESSION['id_number'];
    $university = $_SESSION['university'];
    $campus = $_SESSION['campus'];

    $sql = "INSERT INTO students 
            (full_name, email, student_number, password, contact, nationality, id_number, university, campus) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $full_name, $email, $student_number, $password, $contact, $nationality, $id_number, $university, $campus);

    if ($stmt->execute()) {
        echo "Signup successful!";
        session_destroy();
        header("Location: Student_Dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Missing signup information.";
}

$conn->close();
?>