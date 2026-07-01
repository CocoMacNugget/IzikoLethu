<?php
session_start();

if (isset($_SESSION['student_number'])) {
    session_unset();
    session_destroy();
    header("Location: StudentLogin.php");
    exit;
} elseif (isset($_SESSION['landlord_email'])) {
    session_unset();
    session_destroy();
    header("Location: LandlordLogin.php");
    exit;
} else {
    header("Location: StudentLogin.php");
    exit;
}
?>
