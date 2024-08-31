-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2024 at 01:33 PM
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
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doc_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `type` enum('In-Patient','Consultation') NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `patient_condition` varchar(255) NOT NULL,
  `resuscitation_status` enum('yes','no') NOT NULL,
  `diet` varchar(255) NOT NULL,
  `medical_history` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doc_id`, `date`, `time`, `diagnosis`, `type`, `check_in`, `check_out`, `patient_condition`, `resuscitation_status`, `diet`, `medical_history`) VALUES
(17, 1, 'padi.ayertey', '2024-04-01', '08:00:00', 'Pregnancy', 'In-Patient', '2024-04-01 08:00:00', '2024-07-10 02:03:20', 'Labour', 'yes', 'regular', ''),
(18, 2, 'padi.ayertey', '2024-06-10', '09:00:55', NULL, 'Consultation', '2024-06-12 18:04:24', NULL, '', 'yes', '', NULL),
(19, 4, 'padi.ayertey', '2024-03-21', '09:00:55', NULL, 'Consultation', '2024-08-23 21:57:38', NULL, 'fdgh', 'yes', 'fgvb', NULL),
(20, 4, 'padi.ayertey', '2024-03-21', '09:00:55', NULL, 'In-Patient', '2024-07-17 20:39:48', NULL, 'fdgh', 'yes', 'fgvb', NULL),
(25, 5, 'padi.ayertey', '2024-06-25', '20:00:00', 'Pregnancy', 'In-Patient', '2024-06-25 19:56:54', '2024-07-17 18:30:33', 'Labour', 'yes', 'regular', ''),
(34, 3, 'padi.ayertey', '2024-07-24', '17:45:00', '', 'In-Patient', '2024-07-22 19:53:24', NULL, 'Stable', 'yes', 'regular', ''),
(35, 6, 'padi.ayertey', '2024-08-06', '07:53:00', 'Elective C/S', 'In-Patient', '2024-08-07 16:49:34', NULL, 'Stable', 'yes', 'regular', ''),
(36, 7, 'padi.ayertey', '2024-08-31', '09:00:00', '', 'In-Patient', '2024-08-31 01:22:22', '2024-08-31 07:46:00', 'Labour', 'yes', 'regular', ''),
(37, 8, 'padi.ayertey', '2024-08-31', '10:00:00', '', 'Consultation', NULL, NULL, 'fghj', 'yes', 'regular', '');

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `bed_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` enum('occupied','clean','dirty') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`bed_id`, `room_id`, `status`) VALUES
(1, 1, 'occupied'),
(2, 1, 'occupied'),
(3, 1, 'clean'),
(4, 2, 'occupied'),
(5, 2, 'clean'),
(6, 3, 'dirty'),
(7, 3, 'clean'),
(8, 4, 'clean'),
(9, 5, 'clean');

-- --------------------------------------------------------

--
-- Table structure for table `consumables`
--

CREATE TABLE `consumables` (
  `con_id` int(11) NOT NULL,
  `con_name` varchar(50) NOT NULL,
  `type` enum('General Consumables','Procedural Consumables') NOT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consumables`
--

INSERT INTO `consumables` (`con_id`, `con_name`, `type`, `price`) VALUES
(1, 'Delivery Mats', 'General Consumables', 20),
(2, 'Urine Bags', 'General Consumables', 5.8),
(3, 'Catheter', 'General Consumables', 10.15),
(4, 'Disposable Gloves', 'General Consumables', 1.89),
(5, 'Canula', 'General Consumables', 2.68),
(6, 'Syringe Needles', 'General Consumables', 10.87),
(7, 'Giving Set', 'General Consumables', 3.19),
(8, 'Sanitary Pad', 'General Consumables', NULL),
(9, 'Oxygen', 'General Consumables', 50),
(10, 'c/s pack', 'Procedural Consumables', 370),
(11, 'cytotec', 'Procedural Consumables', NULL),
(12, 'sterile gloves', 'Procedural Consumables', 2.175),
(13, 'savlon', 'Procedural Consumables', 0.13),
(14, 'Water for injection', 'Procedural Consumables', 2.46),
(15, 'cotton', 'Procedural Consumables', 95.2),
(16, 'Suture', 'Procedural Consumables', NULL),
(17, 'gauze', 'Procedural Consumables', NULL),
(18, 'Abdominal pack', 'Procedural Consumables', 11.59),
(19, 'spinal needle', 'Procedural Consumables', NULL),
(20, 'spirit', 'Procedural Consumables', 0.05);

-- --------------------------------------------------------

--
-- Table structure for table `fluid_intake`
--

CREATE TABLE `fluid_intake` (
  `intake_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `oral_type` varchar(50) NOT NULL,
  `amount` double NOT NULL,
  `iv_type` varchar(50) NOT NULL,
  `iv_amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fluid_intake`
--

INSERT INTO `fluid_intake` (`intake_id`, `apt_id`, `oral_type`, `amount`, `iv_type`, `iv_amount`, `date`, `created_by`, `deleted`) VALUES
(1, 20, 'Soup', 20, 'para', 10, '2024-07-25 13:51:33', 'ellie.asare', 0),
(2, 20, 'Juice', 5, 'Diclo', 10, '2024-07-25 16:41:29', 'ellie.asare', 0),
(9, 20, 'Soup', 45, 'para', 7, '2024-07-25 17:27:10', 'ellie.asare', 0),
(10, 36, 'Soup', 2, 'para', 7, '2024-08-31 06:55:57', 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fluid_output`
--

CREATE TABLE `fluid_output` (
  `output_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `u_amount` int(11) NOT NULL,
  `e_amount` int(11) NOT NULL,
  `d_amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fluid_output`
--

INSERT INTO `fluid_output` (`output_id`, `apt_id`, `u_amount`, `e_amount`, `d_amount`, `date`, `created_by`, `deleted`) VALUES
(1, 20, 20, 20, 20, '2024-07-25 14:46:58', 'ellie.asare', 0),
(2, 20, 76, 4, 56, '2024-07-25 17:27:23', 'ellie.asare', 0),
(3, 36, 6, 0, 32, '2024-08-31 06:56:28', 'ellie.asare', 0),
(4, 36, 8, 0, 3, '2024-08-31 06:56:46', 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `lab_id` int(11) NOT NULL,
  `lab_name` varchar(50) NOT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`lab_id`, `lab_name`, `price`) VALUES
(1, 'FBC', 100),
(2, 'LFT', 140),
(3, 'Blood Group', 70),
(4, 'RBS', 50),
(5, 'BUE', 140),
(6, 'Calcium', NULL),
(7, 'Phosphorus', NULL),
(8, 'Magnesium', NULL),
(9, 'Uric Acid', NULL),
(10, 'Phototherapy', 400);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `meal_id` int(11) NOT NULL,
  `meal_name` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`meal_id`, `meal_name`, `price`) VALUES
(1, 'Breakfast 1', 50),
(2, 'Lunch', 100),
(3, 'Dinner', 100),
(4, 'Breakfast 2', 75);

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `med_id` int(11) NOT NULL,
  `med_name` varchar(50) NOT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`med_id`, `med_name`, `price`) VALUES
(1, 'Adrenaline inj', 14.5),
(2, 'Amlodipine inj', 22.33),
(3, 'Amoksiclav 1.2g', 30.16),
(4, 'Arthesunate 120mg', 26.1),
(5, 'Arthesunate 30mg', 14.5),
(6, 'Arthesunate 60mg', 21.75),
(7, 'Augmentin 625mg', 407.6),
(8, 'Azithromycin 500mg', 32),
(9, 'Clexane 40mg', 130.5),
(10, 'Co-amoksiklav 1.2g', 26.1),
(11, 'Cytotec 200mg', 20),
(12, 'IVF - Dextrose 5%', NULL),
(13, 'IVF - Dextrose 10%', 26.1),
(14, 'Syrup Menthodex', 82.22),
(15, 'IVF- Dextrose saline', 26.1),
(16, 'Diclo-denk supp', 84.1),
(17, 'Diclofenac (DICNAC)supp', 15.66),
(18, 'Diclofenac inj', 22),
(19, 'Ephedrine HCL', 72.5),
(20, 'Fentanyl', 65.25),
(21, 'marcaine heavy', 58),
(22, 'Hydralazine', 21.75),
(23, 'Hydrocortisone', 12),
(24, 'Isoflorane inhaler', 942.5),
(25, 'Ketamin', 87),
(26, 'Labetalol 20mg', 50.75),
(27, 'Labetalol 50mg', 72),
(28, 'Metoclopramide 10mg', 10),
(29, 'Metronidazole 500mg', 18.85),
(30, 'Midazolam 15mg', 130),
(31, 'Midazolam 5mg', 137.75),
(32, 'IV - Fleming', 78.16),
(33, 'Morphine 10mg', 65.25),
(34, 'Naloxone', 116),
(35, 'Neostigmine', 58),
(36, 'IVF - Normal saline', 26.1),
(37, 'IM - Diclofenac (Naklofen)', 22.5),
(38, 'Oxcytocin 10', 10),
(39, 'IV - Pabal', 417.6),
(40, 'IV - Paracetamol inff', 26.1),
(41, 'IM - Pethidine 100mg', 87),
(42, 'IV - marcaine plain', 87),
(43, 'IV/IM-Promethazine 50mg', 30),
(44, 'Propofol', 87),
(45, 'IV - No-spa 40mg', 65.25),
(46, 'IVF - Ringers lactate', 26.1),
(47, 'Secnidazole', 20),
(48, 'Supp paracetamol', 29),
(49, 'Suxamethenium', 72.5),
(50, 'Amoksiclav 625', 87),
(51, 'Diclofenac(Dymol)', 22),
(52, 'Tab Paracetamol(Exeter)', 5),
(53, 'Tetracycline ointment', 8.68),
(54, 'Tramadol 100mg', 15),
(55, 'Vecuronium', 87),
(56, 'Vit K', 12),
(57, 'Vitafol', 31.1),
(58, 'Vitamin C', 60),
(59, 'Tranexamic Acid 500mg', 22),
(60, 'Tab Cetrizene 10mg', 2),
(61, 'Tab No-spa 40mg', 5),
(62, 'Tab Fleming', 90);

-- --------------------------------------------------------

--
-- Table structure for table `medstock`
--

CREATE TABLE `medstock` (
  `apt_id` int(11) DEFAULT NULL,
  `med_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `t_date` datetime NOT NULL,
  `dispense_to` enum('Nurses','Theatre','','') DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medstock`
--

INSERT INTO `medstock` (`apt_id`, `med_id`, `quantity`, `stock_id`, `t_date`, `dispense_to`, `created_by`, `deleted`) VALUES
(NULL, 1, 100, 1, '2024-06-25 17:10:26', NULL, 'rose.mary', 0),
(NULL, 3, 100, 2, '2024-06-25 17:13:02', NULL, 'rose.mary', 0),
(17, 3, -4, 3, '2024-06-25 17:13:14', NULL, 'rose.mary', 0),
(17, 3, -7, 4, '2024-07-01 04:29:59', NULL, 'rose.mary', 0),
(20, 7, -30, 5, '2024-07-19 12:35:02', NULL, 'rose.mary', 0),
(20, 7, -6, 6, '2024-07-19 12:35:09', NULL, 'rose.mary', 0),
(NULL, 7, 100, 7, '2024-07-19 12:36:00', NULL, 'rose.mary', 0),
(NULL, 1, -30, 8, '2024-07-24 10:35:00', 'Nurses', 'rose.mary', 0),
(NULL, 3, -10, 9, '2024-07-24 10:40:40', 'Theatre', 'rose.mary', 0),
(NULL, 3, -10, 10, '2024-07-24 10:40:59', 'Nurses', 'rose.mary', 0),
(NULL, 3, -10, 11, '2024-07-24 10:41:22', 'Nurses', 'rose.mary', 0),
(NULL, 7, -10, 12, '2024-07-24 10:41:51', 'Nurses', 'rose.mary', 0),
(NULL, 1, -50, 13, '2024-08-15 15:53:46', 'Theatre', 'rose.mary', 0),
(17, 3, -1, 14, '2024-08-15 16:08:04', NULL, 'rose.mary', 0),
(17, 32, -18, 15, '2024-08-15 16:21:16', NULL, 'rose.mary', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `notes_id` int(11) NOT NULL,
  `type` enum('nur_notes','doc_notes','dis_notes','') NOT NULL,
  `apt_id` int(11) NOT NULL,
  `notes` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`notes_id`, `type`, `apt_id`, `notes`, `date`, `created_by`, `deleted`) VALUES
(1, 'nur_notes', 34, 'Testing that its working', '2024-07-28 22:16:24', 'ellie.asare', 0),
(2, 'nur_notes', 34, 'Second Value', '2024-07-28 22:16:24', 'ellie.asare', 0),
(4, 'nur_notes', 34, 'Prior test value', '2024-07-27 20:18:29', 'ellie.asare', 0),
(5, 'nur_notes', 34, 'Input from site test', '2024-07-28 23:35:55', 'ellie.asare', 0),
(6, 'nur_notes', 20, 'test', '2024-08-27 10:06:06', 'ellie.asare', 0),
(7, 'nur_notes', 20, 'trying', '2024-08-27 10:07:54', 'ellie.asare', 0),
(13, 'doc_notes', 20, 'Testing testing', '2024-08-27 13:49:24', 'padi.ayertey', 0),
(14, 'doc_notes', 20, 'it works', '2024-08-27 13:49:32', 'padi.ayertey', 0),
(15, 'doc_notes', 20, 'it works', '2024-08-27 13:53:02', 'padi.ayertey', 0),
(16, 'doc_notes', 20, 'it works', '2024-08-27 13:53:50', 'padi.ayertey', 0),
(17, 'doc_notes', 20, 'it works', '2024-08-27 13:54:10', 'padi.ayertey', 0),
(18, 'doc_notes', 20, 'it works', '2024-08-27 13:54:54', 'padi.ayertey', 0),
(19, 'doc_notes', 20, 'it works', '2024-08-27 13:57:04', 'padi.ayertey', 0),
(33, 'doc_notes', 36, 'Test', '2024-08-31 00:05:36', 'padi.ayertey', 0),
(34, 'doc_notes', 36, 'test 2', '2024-08-31 00:05:44', 'padi.ayertey', 0),
(35, 'dis_notes', 36, 'Ready', '2024-08-31 01:05:32', 'padi.ayertey', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `FName` varchar(255) NOT NULL,
  `LName` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `financial_type` varchar(255) DEFAULT NULL,
  `pat_id` int(11) NOT NULL,
  `guardian_fname` varchar(255) DEFAULT NULL,
  `guardian_lname` varchar(255) DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') NOT NULL,
  `address` text NOT NULL,
  `patient_phone` varchar(13) NOT NULL,
  `patient_email` varchar(255) NOT NULL,
  `guardian_phone` varchar(13) DEFAULT NULL,
  `guardian_email` varchar(255) DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `employment` varchar(255) DEFAULT NULL,
  `special_codes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`FName`, `LName`, `DOB`, `gender`, `financial_type`, `pat_id`, `guardian_fname`, `guardian_lname`, `marital_status`, `address`, `patient_phone`, `patient_email`, `guardian_phone`, `guardian_email`, `referred_by`, `registration_date`, `employment`, `special_codes`) VALUES
('Anna', 'Efi', '2014-03-01', 'Male', 'Insurance', 1, NULL, NULL, '', '67 Lashibi Lane', '032135434', 'asda@gmail.com', NULL, NULL, NULL, '2024-06-06', NULL, NULL),
('Sarah', 'Ala', '2012-03-05', 'Male', 'Insurance', 2, NULL, NULL, 'Single', '67 Lashibi Lane', '0234221124', 'nasm@gmail.com', NULL, NULL, NULL, '2024-06-05', NULL, NULL),
('Bryan Tetteh Emahi', 'Ayertey', '2024-06-12', 'Female', 'Insurance', 3, 'Bryan Tetteh Emahi', 'Ayertey', 'Single', 'P.O. Box SK 1605', '0531691557', 'm@b', '0531691557', 'hm@b', '', '2024-06-12', '', ''),
('Elkan', 'Ayertey', '2024-03-01', 'Male', 'Insurance', 4, '', '', 'Single', 'Local', '0531691557', 't@b', '', '', '', '2024-06-01', '', ''),
('Maame', 'Ntim', '2024-02-06', 'Female', 'Insurance', 5, 'Bryan Tetteh Emahi', 'Ayertey', 'Single', 'njvdfsam', '0531691545', 'm@b', '', '', 'adsfdg', '2024-06-25', '', ''),
('Faustina', 'Achampong', '1979-11-11', 'Female', 'Insurance', 6, 'Richard', 'Boateng', 'Married', 'sdfghujkl', '0244964476', 'm@b', '', '', '', '2024-08-07', '', 'Green'),
('Bismarck', 'Osei', '2024-08-31', 'Male', 'Insurance', 7, '', '', 'Single', 'YQ', '02354235643', 'cd@ng', '', '', '', '2024-08-30', '', ''),
('Rose', 'Mary', '2024-08-30', 'Female', 'fdgh', 8, '', '', 'Single', 'gf', '345677890', 'fghjk@nmg', '', '', '', '2024-08-31', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `patients_beds`
--

CREATE TABLE `patients_beds` (
  `assign_id` int(11) NOT NULL,
  `bed_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_beds`
--

INSERT INTO `patients_beds` (`assign_id`, `bed_id`, `apt_id`, `end_date`, `start_date`, `created_by`, `deleted`) VALUES
(1, 8, 17, '2024-06-23 20:49:51', '2024-06-19 21:17:10', 'ellie.asare', 0),
(2, 5, 18, '2024-06-24 14:58:16', '2024-06-20 14:09:00', 'ellie.asare', 0),
(5, 1, 17, '2024-05-30 04:24:00', '2024-05-25 03:45:00', 'ellie.asare', 0),
(9, 4, 17, '2024-06-04 15:51:00', '2024-05-30 04:24:00', 'ellie.asare', 0),
(10, 8, 17, '2024-06-23 20:49:51', '2024-06-18 15:51:00', 'ellie.asare', 0),
(11, 9, 17, '2024-06-23 21:00:13', '2024-06-23 20:52:46', 'ellie.asare', 0),
(12, 5, 17, '2024-07-15 18:23:22', '2024-06-23 21:00:13', 'ellie.asare', 0),
(13, 2, 25, '2024-07-10 23:07:11', '2024-06-25 20:11:45', 'ellie.asare', 0),
(16, 3, 25, '2024-07-17 18:31:59', '2024-07-10 23:07:11', 'ellie.asare', 0),
(17, 1, 20, NULL, '2024-07-19 12:51:22', 'ellie.asare', 0),
(20, 2, 34, NULL, '2024-07-22 19:52:46', 'ellie.asare', 0),
(22, 3, 35, NULL, '2024-08-07 16:49:34', 'ellie.asare', 0),
(23, 4, 35, NULL, '2024-08-07 16:50:43', 'ellie.asare', 0),
(27, 6, 36, '2024-08-31 07:46:00', '2024-08-31 01:22:22', 'elkan.ayertey', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients_cons`
--

CREATE TABLE `patients_cons` (
  `p_cons_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `con_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_cons`
--

INSERT INTO `patients_cons` (`p_cons_id`, `apt_id`, `con_id`, `count`, `date`, `created_by`, `deleted`) VALUES
(1, 17, 10, 3, '2024-07-01 20:29:43', 'ellie.asare', 0),
(2, 17, 10, 4, '2024-07-01 20:29:43', 'ellie.asare', 0),
(3, 20, 1, 10, '2024-07-18 17:08:44', 'ellie.asare', 0),
(4, 36, 1, 10, '2024-08-31 06:52:47', 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients_labs`
--

CREATE TABLE `patients_labs` (
  `p_lab_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `apt_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `lab_results` varchar(255) DEFAULT NULL,
  `lab_date` datetime DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_labs`
--

INSERT INTO `patients_labs` (`p_lab_id`, `date`, `apt_id`, `lab_id`, `lab_results`, `lab_date`, `created_by`, `deleted`) VALUES
(1, '2024-06-09 10:37:00', 17, 1, 'HANNAH ACQUAH SARKODIE 2024-05-02.pdf', '2024-06-10 00:00:00', 'padi.ayertey', 0),
(4, '2024-06-10 14:39:35', 17, 3, 'Millicent Akolatse.pdf', '2024-06-23 19:22:27', 'padi.ayertey', 0),
(5, '2024-06-10 14:48:39', 17, 2, NULL, NULL, 'padi.ayertey', 0),
(6, '2024-06-24 13:04:39', 17, 1, NULL, NULL, 'padi.ayertey', 0),
(7, '2024-07-01 00:58:44', 19, 1, NULL, NULL, 'padi.ayertey', 0),
(8, '2024-07-01 02:17:23', 19, 2, NULL, NULL, 'padi.ayertey', 0),
(9, '2024-07-18 17:23:23', 20, 1, NULL, NULL, 'padi.ayertey', 0),
(10, '2024-07-28 23:14:54', 34, 1, NULL, NULL, 'padi.ayertey', 0),
(11, '2024-08-31 00:17:26', 36, 1, NULL, NULL, 'padi.ayertey', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients_meals`
--

CREATE TABLE `patients_meals` (
  `p_meal_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `apt_id` int(11) NOT NULL,
  `served` datetime DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_meals`
--

INSERT INTO `patients_meals` (`p_meal_id`, `meal_id`, `date`, `apt_id`, `served`, `created_by`, `deleted`) VALUES
(1, 2, '2024-06-24 18:23:35', 20, '2024-06-24 18:51:34', 'ellie.asare', 0),
(2, 3, '2024-07-01 20:01:10', 17, '2024-07-02 18:01:10', 'ellie.asare', 0),
(3, 3, '2024-07-01 20:01:10', 17, '2024-07-02 18:01:10', 'ellie.asare', 0),
(4, 1, '2024-07-10 23:43:32', 25, NULL, 'ellie.asare', 0),
(5, 2, '2024-08-31 06:52:53', 36, NULL, 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients_meds`
--

CREATE TABLE `patients_meds` (
  `p_med_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `per_dose` int(11) NOT NULL,
  `per_day` int(11) NOT NULL,
  `num_days` int(11) NOT NULL,
  `num_months` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `time_ad` datetime DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `ad_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_meds`
--

INSERT INTO `patients_meds` (`p_med_id`, `apt_id`, `med_id`, `per_dose`, `per_day`, `num_days`, `num_months`, `date`, `time_ad`, `created_by`, `deleted`, `ad_by`) VALUES
(7, 17, 3, 2, 1, 2, 0, '2024-06-20 15:30:04', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(8, 17, 3, 2, 1, 2, 0, '2024-06-20 15:41:34', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(9, 17, 3, 2, 1, 2, 0, '2024-06-22 15:55:04', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(10, 17, 3, 2, 1, 2, 0, '2024-06-22 16:33:03', '2024-06-24 20:06:38', 'padi.ayertey', 0, 'ellie.asare'),
(12, 17, 32, 3, 2, 3, 3, '2024-06-24 14:51:56', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(14, 20, 7, 3, 2, 3, 0, '2024-07-01 06:11:45', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(15, 20, 7, 3, 2, 3, 0, '2024-07-01 06:11:45', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(16, 34, 1, 3, 2, 1, 0, '2024-07-28 23:16:20', NULL, 'padi.ayertey', 0, 'ellie.asare'),
(21, 36, 1, 3, 2, 3, 0, '2024-08-31 00:54:41', NULL, 'padi.ayertey', 1, 'padi.ayertey'),
(22, 36, 3, 1, 1, 1, 1, '2024-08-31 01:05:18', NULL, 'padi.ayertey', 1, 'padi.ayertey');

-- --------------------------------------------------------

--
-- Table structure for table `patients_proc`
--

CREATE TABLE `patients_proc` (
  `apt_id` int(11) NOT NULL,
  `proc_id` int(11) NOT NULL,
  `p_proc_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_proc`
--

INSERT INTO `patients_proc` (`apt_id`, `proc_id`, `p_proc_id`, `date`, `created_by`, `deleted`) VALUES
(17, 1, 1, '2024-05-01 21:04:30', 'padi.ayertey', 0),
(17, 2, 2, '2024-05-01 21:04:40', 'padi.ayertey', 0),
(17, 3, 3, '2024-05-01 21:04:48', 'padi.ayertey', 0),
(17, 6, 4, '2024-06-24 11:41:04', 'padi.ayertey', 0),
(25, 1, 11, '2024-06-27 17:40:47', 'padi.ayertey', 0),
(20, 1, 12, '2024-07-19 12:33:22', 'padi.ayertey', 0),
(36, 6, 13, '2024-08-31 00:16:48', 'padi.ayertey', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients_procmeds`
--

CREATE TABLE `patients_procmeds` (
  `p_ppmeds_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `apt_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_procmeds`
--

INSERT INTO `patients_procmeds` (`p_ppmeds_id`, `med_id`, `quantity`, `date`, `apt_id`, `created_by`, `deleted`) VALUES
(1, 2, 1, '2024-07-18 16:54:41', 20, 'ellie.asare', 0),
(2, 2, 1, '2024-07-18 17:00:36', 20, 'ellie.asare', 0),
(3, 2, 1, '2024-07-18 17:04:25', 20, 'ellie.asare', 0),
(4, 2, 1, '2024-07-18 17:05:48', 20, 'ellie.asare', 0),
(5, 1, 1, '2024-08-31 06:55:36', 36, 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients_vits`
--

CREATE TABLE `patients_vits` (
  `p_vit_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `apt_id` int(11) NOT NULL,
  `vit_id` int(11) NOT NULL,
  `measure` double NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_vits`
--

INSERT INTO `patients_vits` (`p_vit_id`, `date`, `apt_id`, `vit_id`, `measure`, `created_by`, `deleted`) VALUES
(61, '2024-07-24 17:03:52', 20, 1, 30.2, 'ellie.asare', 0),
(62, '2024-07-24 17:03:52', 20, 2, 16, 'ellie.asare', 0),
(63, '2024-07-24 17:03:52', 20, 3, 45, 'ellie.asare', 0),
(64, '2024-07-24 17:03:52', 20, 4, 25, 'ellie.asare', 0),
(65, '2024-07-24 17:03:52', 20, 6, 98, 'ellie.asare', 0),
(66, '2024-07-24 17:03:52', 20, 5, 10, 'ellie.asare', 0),
(67, '2024-08-07 16:58:13', 35, 1, 36.4, 'ellie.asare', 0),
(68, '2024-08-07 16:58:13', 35, 2, 88, 'ellie.asare', 0),
(69, '2024-08-07 16:58:13', 35, 3, 17, 'ellie.asare', 0),
(70, '2024-08-07 16:58:13', 35, 4, 77, 'ellie.asare', 0),
(71, '2024-08-07 16:58:13', 35, 6, 97, 'ellie.asare', 0),
(72, '2024-08-07 16:58:13', 35, 5, 126, 'ellie.asare', 0),
(73, '2024-08-27 13:43:57', 20, 1, 36.4, 'ellie.asare', 0),
(74, '2024-08-27 13:43:57', 20, 2, 122, 'ellie.asare', 0),
(75, '2024-08-27 13:43:57', 20, 3, 45, 'ellie.asare', 0),
(76, '2024-08-27 13:43:57', 20, 4, 77, 'ellie.asare', 0),
(77, '2024-08-27 13:43:57', 20, 6, 97, 'ellie.asare', 0),
(78, '2024-08-27 13:43:57', 20, 5, 10, 'ellie.asare', 0),
(79, '2024-08-31 06:55:19', 36, 1, 30.2, 'ellie.asare', 0),
(80, '2024-08-31 06:55:19', 36, 2, 122, 'ellie.asare', 0),
(81, '2024-08-31 06:55:19', 36, 3, 45, 'ellie.asare', 0),
(82, '2024-08-31 06:55:19', 36, 4, 77, 'ellie.asare', 0),
(83, '2024-08-31 06:55:19', 36, 6, 97, 'ellie.asare', 0),
(84, '2024-08-31 06:55:19', 36, 5, 126, 'ellie.asare', 0),
(89, '2024-08-31 09:27:16', 18, 1, 30.2, 'elkan.ayertey', 0),
(90, '2024-08-31 09:27:16', 18, 2, 122, 'elkan.ayertey', 0),
(91, '2024-08-31 09:27:16', 18, 3, 45, 'elkan.ayertey', 0),
(92, '2024-08-31 09:27:16', 18, 4, 1293, 'elkan.ayertey', 0),
(93, '2024-08-31 09:33:22', 18, 1, 30.2, 'elkan.ayertey', 0),
(94, '2024-08-31 09:33:22', 18, 2, 122, 'elkan.ayertey', 0),
(95, '2024-08-31 09:33:22', 18, 3, 45, 'elkan.ayertey', 0),
(96, '2024-08-31 09:33:22', 18, 4, 77, 'elkan.ayertey', 0),
(97, '2024-08-31 09:33:22', 18, 6, 97, 'elkan.ayertey', 0),
(98, '2024-08-31 09:33:22', 18, 5, 10, 'elkan.ayertey', 0),
(99, '2024-08-31 09:35:36', 18, 1, 30.2, 'elkan.ayertey', 0),
(100, '2024-08-31 09:35:36', 18, 2, 122, 'elkan.ayertey', 0),
(101, '2024-08-31 09:35:36', 18, 3, 45, 'elkan.ayertey', 0),
(102, '2024-08-31 09:35:36', 18, 4, 77, 'elkan.ayertey', 0),
(103, '2024-08-31 09:35:36', 18, 6, 97, 'elkan.ayertey', 0),
(104, '2024-08-31 09:35:36', 18, 5, 10, 'elkan.ayertey', 0),
(105, '2024-08-31 09:35:45', 18, 1, 30.2, 'elkan.ayertey', 0),
(106, '2024-08-31 09:35:45', 18, 2, 122, 'elkan.ayertey', 0),
(107, '2024-08-31 09:35:45', 18, 3, 45, 'elkan.ayertey', 0),
(108, '2024-08-31 09:35:45', 18, 4, 77, 'elkan.ayertey', 0),
(109, '2024-08-31 09:35:45', 18, 6, 97, 'elkan.ayertey', 0),
(110, '2024-08-31 09:35:45', 18, 5, 10, 'elkan.ayertey', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_prog`
--

CREATE TABLE `patient_prog` (
  `p_prog_id` int(11) NOT NULL,
  `prog_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `measure` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_prog`
--

INSERT INTO `patient_prog` (`p_prog_id`, `prog_id`, `apt_id`, `measure`, `date`, `created_by`, `deleted`) VALUES
(2, 1, 34, '10', '2024-07-31 01:13:04', 'ellie.asare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `preg_progress`
--

CREATE TABLE `preg_progress` (
  `prog_id` int(11) NOT NULL,
  `prog_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preg_progress`
--

INSERT INTO `preg_progress` (`prog_id`, `prog_name`) VALUES
(1, 'Cervix'),
(2, 'Descent of Head'),
(3, 'Amniotic Fluid'),
(4, 'Contractions Per 10 mini'),
(6, 'Descent of Head'),
(7, 'Oxytocin'),
(8, 'Contractions Per 10 mini'),
(9, 'Fetal Heart Rate'),
(10, 'Body Temperature'),
(11, 'Protein'),
(12, 'Acetone'),
(13, 'Volume');

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE `procedures` (
  `prod_id` int(11) NOT NULL,
  `Prod_Name` varchar(50) NOT NULL,
  `Price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`prod_id`, `Prod_Name`, `Price`) VALUES
(1, 'Caeserean Section 1', 8000),
(2, 'Caeserean Section 2', 8500),
(3, 'Caeserean Section Twins', 9500),
(4, 'Caeserean Section Myomectomy', 10000),
(5, 'Dermabond', 500),
(6, 'Vaginal Delivery', 4000),
(7, 'Episiotomy and repair', 600),
(8, 'Vacuum Extraction', 1500),
(9, 'Epidural', 2000),
(10, 'CTG - 20 minutes', 200),
(11, 'CTG - Continuous', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `capacity`, `unit`, `price`) VALUES
(1, 3, '1', 500),
(2, 2, '1', 700),
(3, 2, '1', 600),
(4, 1, '1', 1000),
(5, 1, '1', 900);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `floor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_name`, `floor`) VALUES
(1, 'Surgery', 1),
(2, 'NICU', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `user_type` enum('Doctor','Nurse','Lab Tech','Pharmacist','Front Desk','Cashier') NOT NULL,
  `password` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `user_type`, `password`, `Name`) VALUES
('bryan.ayertey', 'Cashier', '12345', 'Bryan Ayertey'),
('daryl.ayertey', 'Doctor', '12345', 'Daryl Ayertey'),
('elkan.ayertey', 'Front Desk', '12345', 'Elkan Ayertey'),
('ellie.asare', 'Nurse', '12345', 'Ellie Asare'),
('padi.ayertey', 'Doctor', '12345', 'Padi Ayertey'),
('rose.mary', 'Pharmacist', '12345', 'Rose Mary'),
('yvonne.kofi', 'Lab Tech', '12345', 'Yvonne Kofi');

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
(6, 'Oxygen Saturation', 95, 100, 0, 101);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_id` (`doc_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`bed_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `consumables`
--
ALTER TABLE `consumables`
  ADD PRIMARY KEY (`con_id`);

--
-- Indexes for table `fluid_intake`
--
ALTER TABLE `fluid_intake`
  ADD PRIMARY KEY (`intake_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `fluid_output`
--
ALTER TABLE `fluid_output`
  ADD PRIMARY KEY (`output_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`meal_id`);

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `medstock`
--
ALTER TABLE `medstock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `apt_id` (`apt_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`notes_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`pat_id`);

--
-- Indexes for table `patients_beds`
--
ALTER TABLE `patients_beds`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `bed_id` (`bed_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patients_cons`
--
ALTER TABLE `patients_cons`
  ADD PRIMARY KEY (`p_cons_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `cons_id` (`con_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patients_labs`
--
ALTER TABLE `patients_labs`
  ADD PRIMARY KEY (`p_lab_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patients_meals`
--
ALTER TABLE `patients_meals`
  ADD PRIMARY KEY (`p_meal_id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `apt_id` (`apt_id`);

--
-- Indexes for table `patients_meds`
--
ALTER TABLE `patients_meds`
  ADD PRIMARY KEY (`p_med_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `ad_by` (`ad_by`);

--
-- Indexes for table `patients_proc`
--
ALTER TABLE `patients_proc`
  ADD PRIMARY KEY (`p_proc_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `proc_id` (`proc_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patients_procmeds`
--
ALTER TABLE `patients_procmeds`
  ADD PRIMARY KEY (`p_ppmeds_id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `apt_id` (`apt_id`);

--
-- Indexes for table `patients_vits`
--
ALTER TABLE `patients_vits`
  ADD PRIMARY KEY (`p_vit_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `vit_id` (`vit_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patient_prog`
--
ALTER TABLE `patient_prog`
  ADD PRIMARY KEY (`p_prog_id`),
  ADD KEY `prog_id` (`prog_id`),
  ADD KEY `apt_id` (`apt_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `preg_progress`
--
ALTER TABLE `preg_progress`
  ADD PRIMARY KEY (`prog_id`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`vit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `bed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consumables`
--
ALTER TABLE `consumables`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fluid_intake`
--
ALTER TABLE `fluid_intake`
  MODIFY `intake_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fluid_output`
--
ALTER TABLE `fluid_output`
  MODIFY `output_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `medstock`
--
ALTER TABLE `medstock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `notes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients_beds`
--
ALTER TABLE `patients_beds`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `patients_cons`
--
ALTER TABLE `patients_cons`
  MODIFY `p_cons_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients_labs`
--
ALTER TABLE `patients_labs`
  MODIFY `p_lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patients_meals`
--
ALTER TABLE `patients_meals`
  MODIFY `p_meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients_meds`
--
ALTER TABLE `patients_meds`
  MODIFY `p_med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `patients_proc`
--
ALTER TABLE `patients_proc`
  MODIFY `p_proc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patients_procmeds`
--
ALTER TABLE `patients_procmeds`
  MODIFY `p_ppmeds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients_vits`
--
ALTER TABLE `patients_vits`
  MODIFY `p_vit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `patient_prog`
--
ALTER TABLE `patient_prog`
  MODIFY `p_prog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `preg_progress`
--
ALTER TABLE `preg_progress`
  MODIFY `prog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `vit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`pat_id`);

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `fluid_intake`
--
ALTER TABLE `fluid_intake`
  ADD CONSTRAINT `fluid_intake_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `fluid_intake_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `fluid_output`
--
ALTER TABLE `fluid_output`
  ADD CONSTRAINT `fluid_output_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `fluid_output_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `medstock`
--
ALTER TABLE `medstock`
  ADD CONSTRAINT `medstock_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `medication` (`med_id`),
  ADD CONSTRAINT `medstock_ibfk_2` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_beds`
--
ALTER TABLE `patients_beds`
  ADD CONSTRAINT `patients_beds_ibfk_1` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`bed_id`),
  ADD CONSTRAINT `patients_beds_ibfk_2` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_beds_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_cons`
--
ALTER TABLE `patients_cons`
  ADD CONSTRAINT `patients_cons_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_cons_ibfk_2` FOREIGN KEY (`con_id`) REFERENCES `consumables` (`con_id`),
  ADD CONSTRAINT `patients_cons_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_labs`
--
ALTER TABLE `patients_labs`
  ADD CONSTRAINT `patients_labs_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_labs_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`),
  ADD CONSTRAINT `patients_labs_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_meals`
--
ALTER TABLE `patients_meals`
  ADD CONSTRAINT `patients_meals_ibfk_1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`meal_id`),
  ADD CONSTRAINT `patients_meals_ibfk_2` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `patients_meds`
--
ALTER TABLE `patients_meds`
  ADD CONSTRAINT `patients_meds_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_meds_ibfk_2` FOREIGN KEY (`med_id`) REFERENCES `medication` (`med_id`),
  ADD CONSTRAINT `patients_meds_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `patients_meds_ibfk_4` FOREIGN KEY (`ad_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_proc`
--
ALTER TABLE `patients_proc`
  ADD CONSTRAINT `patients_proc_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_proc_ibfk_2` FOREIGN KEY (`proc_id`) REFERENCES `procedures` (`prod_id`),
  ADD CONSTRAINT `patients_proc_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patients_procmeds`
--
ALTER TABLE `patients_procmeds`
  ADD CONSTRAINT `patients_procmeds_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `medication` (`med_id`),
  ADD CONSTRAINT `patients_procmeds_ibfk_2` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `patients_vits`
--
ALTER TABLE `patients_vits`
  ADD CONSTRAINT `patients_vits_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patients_vits_ibfk_2` FOREIGN KEY (`vit_id`) REFERENCES `vitals` (`vit_id`),
  ADD CONSTRAINT `patients_vits_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `patient_prog`
--
ALTER TABLE `patient_prog`
  ADD CONSTRAINT `patient_prog_ibfk_1` FOREIGN KEY (`prog_id`) REFERENCES `preg_progress` (`prog_id`),
  ADD CONSTRAINT `patient_prog_ibfk_2` FOREIGN KEY (`apt_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `patient_prog_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
