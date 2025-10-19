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
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` int UNSIGNED DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `student_number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `university` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `campus` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `student_number` (`student_number`),
  KEY `fk_student_property` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Student information table';

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `property_id`, `full_name`, `email`, `student_number`, `password`, `contact`, `nationality`, `id_number`, `university`, `campus`, `created_at`) VALUES
(1, NULL, 'Jake', '294763976@mycput.ac.za', '294763976', '99999', '0873452967', 'South Africa', '4789357829782', 'University of Cape Town', 'UCT Graduate School of Business', '2025-09-25 16:09:53'),
(2, NULL, 'Gray Adams', '675397856@mycput.ac.za', '675397856', 'gray6', '0875647823', 'South Africa', '4389507643256', 'Stellenbosch University', 'Stellenbosch', '2025-10-14 12:11:58');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
