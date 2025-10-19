-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2025 at 06:34 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `izikolethu`
--

-- --------------------------------------------------------

--
-- Table structure for table `landlords`
--

DROP TABLE IF EXISTS `landlords`;
CREATE TABLE IF NOT EXISTS `landlords` (
  `landlord_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `business_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number_of_properties` int NOT NULL,
  `id_document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proof_of_ownership` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `preferred_student_type` enum('Undergraduate','Postgraduate','Any') COLLATE utf8mb4_general_ci NOT NULL,
  `lease_duration` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`landlord_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Landlord Information';

--
-- Dumping data for table `landlords`
--

INSERT INTO `landlords` (`landlord_id`, `full_name`, `email`, `password`, `contact`, `business_name`, `number_of_properties`, `id_document`, `proof_of_ownership`, `preferred_student_type`, `lease_duration`, `created_at`) VALUES
(1, 'Andy Brown', 'andybrown9@gmail.com', 'andybrown9', '0673456789', 'Andy\'s co.', 1, 'uploads/68ecf777cc7fd_Screenshot (50).png', 'uploads/68ecf777cc803_Screenshot 2025-02-11 164447.png', 'Any', 'Flexible', '2025-10-13 13:02:10'),
(2, 'Larry Gray', 'larraygray78@gmail.com', 'larraygray7', '0457862378', 'Larry co.', 1, 'uploads/68ee3ef9402ab_Screenshot 2025-02-11 165501.png', 'uploads/68ee3ef940382_Screenshot 2025-02-11 165953.png', 'Any', '12 Months', '2025-10-14 12:16:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
