-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 05:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elimmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE `vitals` (
  `vit_id` int(11) NOT NULL,
  `vital_name` varchar(250) NOT NULL,
  `min_stable` int(11) NOT NULL,
  `max_stable` int(11) NOT NULL,
  `low_danger` int(11) NOT NULL,
  `high_danger` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vitals`
--

INSERT INTO `vitals` (`vit_id`, `vital_name`, `min_stable`, `max_stable`, `low_danger`, `high_danger`) VALUES
(1, 'Body Temperature', 36, 37, 34, 38),
(2, 'Pulse Rate', 60, 90, 40, 120),
(3, 'Respiration Rate', 11, 20, 10, 31),
(4, 'Diastolic Blood Pressure', 60, 80, 40, 110),
(5, 'Systolic Blood Pressure', 100, 130, 80, 160),
(6, 'Oxygen Saturation', 95, 100, 0, 101),
(7, 'Weight', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`vit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `vit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
