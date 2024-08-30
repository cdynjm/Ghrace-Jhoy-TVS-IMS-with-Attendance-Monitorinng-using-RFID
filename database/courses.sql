-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2024 at 12:03 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gjtvs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `sector` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `copr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `sector`, `qualification`, `status`, `copr`, `created_at`, `updated_at`) VALUES
(1, 'Human Health/Health Care', 'Health Care Services NC II HHCHC205', 'WTR', '000-001', '2024-06-04 11:02:38', '2024-07-04 00:41:10'),
(2, 'Tourism (Hotel and Restaurant)', 'Food and Beverage Services NC II - TRSFB213', 'WTR', '000-002', '2024-06-04 11:06:15', '2024-08-28 02:56:22'),
(3, 'Tourism (Hotel and Restaurant)', 'Cookery NC II - TRSCOK214', 'WTR', '000-003', '2024-06-04 11:19:34', '2024-06-21 04:06:56'),
(4, 'Tourism (Hotel and Restaurant)', 'Cookery NC II Prepare and Cook Hot Meals - TRSCOK214', 'WTR-Cluster', '000-004', '2024-06-04 11:31:02', '2024-06-09 09:11:15'),
(5, 'Tourism (Hotel and Restaurant)', 'Cookery NC II Prepare Cold Meals - TRSCOK214', 'WTR-Cluster', '000-005', '2024-06-04 11:32:38', '2024-06-09 03:03:44'),
(6, 'Tourism (Hotel and Restaurant)', 'Cookery NC II Prepare Sweets - TRSCOK214', 'WTR-Cluster', '000-006', '2024-06-04 11:33:03', '2024-06-14 01:47:28'),
(7, 'TVET', 'Trainers Methodology Level I', 'WTR', '000-007', '2024-06-04 23:16:34', '2024-06-18 07:07:48'),
(8, 'Construction', 'Masonry NC II - CONMAS218', 'WTR', '000-008', '2024-06-04 23:18:42', '2024-07-24 09:35:52'),
(9, 'Construction', 'Carpentry NC II - CONCAR218', 'WTR', '000-009', '2024-06-04 23:20:32', '2024-07-15 00:17:12'),
(14, 'Automotive and Land Transportation', 'Driving NC II - ALTDRV204', 'WTR', '000-010', '2024-06-05 00:16:32', '2024-07-17 03:08:23'),
(15, 'Construction', 'Tile Setting NC II - CONTIL218', 'WTR', '000-011,', '2024-06-05 00:19:58', '2024-06-17 02:04:00'),
(16, 'Tourism (Hotel and Restaurant)', 'Bread and Pastry Production NC  II - TRSBPP209', 'WTR', '000-012', '2024-06-05 00:41:21', '2024-06-09 05:16:44'),
(17, 'Human Health/Health Care', 'Contact Tracin Level II - COC', 'NTR', '000-013', '2024-06-05 06:05:06', '2024-06-17 01:29:26'),
(18, 'Tourism (Hotel and Restaurant)', 'Three (3) Year Diploma Program in Hospitality Management', 'NTR-PQF Level 5 (Diploma)', '000-014', '2024-06-05 06:06:29', '2024-06-05 06:06:29'),
(19, 'Automotive and Land Transportation', 'Driving (Passenger Bus/Straight Truck) NC III ALTDRB311', 'WTR', '000-015', '2024-06-05 06:07:42', '2024-08-14 05:32:02'),
(20, 'Tourism (Hotel and Restaurant)', 'Commercial Cooking NC III - TRSCOK307', 'WTR', '000-016', '2024-06-05 06:08:29', '2024-06-17 01:33:54'),
(21, 'Human Health/Health Care', 'Lifelong Learning Skills: Basic Healthcare for TVET Provider', 'For Monitoring of Other Programs', '000-017', '2024-06-05 06:09:40', '2024-06-17 01:14:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
