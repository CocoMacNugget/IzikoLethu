<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: student_login.php");
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

if (isset($_POST['update_personal'])) {
    $sql = "UPDATE students SET full_name=?, email=?, contact=?, nationality=?, id_number=? WHERE student_number=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss",
        $_POST['full_name'], $_POST['email'], $_POST['contact'],
        $_POST['nationality'], $_POST['id_number'], $student_number
    );
    if ($stmt->execute()) {
        $_SESSION['success'] = "Personal information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating personal info: " . $stmt->error;
    }
}

if (isset($_POST['update_university'])) {
    $sql = "UPDATE students SET university=?, campus=? WHERE student_number=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_POST['university'], $_POST['campus'], $student_number);
    if ($stmt->execute()) {
        $_SESSION['success'] = "University information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating university info: " . $stmt->error;
    }
}

if (isset($_POST['update_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM students WHERE student_number=?");
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student || $student['password'] !== $current) {
        $_SESSION['error'] = "Current password is incorrect!";
    } elseif ($new !== $confirm) {
        $_SESSION['error'] = "New password and confirmation do not match!";
    } else {
        $update = $conn->prepare("UPDATE students SET password=? WHERE student_number=?");
        $update->bind_param("ss", $new, $student_number);
        if ($update->execute()) {
            $_SESSION['success'] = "Password updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating password: " . $update->error;
        }
    }
}

$conn->close();
header("Location: Student_Dashboard.php");
exit;
?>
