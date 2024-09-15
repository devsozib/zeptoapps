-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2024 at 11:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zepto`
--

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `name`, `file_name`, `uploaded_at`) VALUES
(6, 'Freedom-10eM', '66e6cb8c25787.ttf', '2024-09-15 11:57:00'),
(7, 'ShadeBlue-2OozX', '66e6cb9074e56.ttf', '2024-09-15 11:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `font_groups`
--

CREATE TABLE `font_groups` (
  `id` int NOT NULL,
  `group_title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `font_groups`
--

INSERT INTO `font_groups` (`id`, `group_title`, `created_at`, `updated_at`) VALUES
(1, 'Test Gorup', '2024-09-15 11:57:21', '2024-09-15 11:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `font_group_fonts`
--

CREATE TABLE `font_group_fonts` (
  `id` int NOT NULL,
  `font_group_id` int NOT NULL,
  `font_name` varchar(255) DEFAULT NULL,
  `font_id` int NOT NULL,
  `specific_size` decimal(5,2) DEFAULT NULL,
  `price_change` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `font_group_fonts`
--

INSERT INTO `font_group_fonts` (`id`, `font_group_id`, `font_name`, `font_id`, `specific_size`, `price_change`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ina Blackburn', 7, 88.00, 730.00, '2024-09-15 11:57:21', '2024-09-15 11:57:21'),
(2, 1, 'Martena Powers', 6, 79.00, 152.00, '2024-09-15 11:57:21', '2024-09-15 11:57:21'),
(3, 1, 'Rama Petty', 7, 68.00, 973.00, '2024-09-15 11:57:21', '2024-09-15 11:57:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `font_groups`
--
ALTER TABLE `font_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `font_group_fonts`
--
ALTER TABLE `font_group_fonts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `font_groups`
--
ALTER TABLE `font_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `font_group_fonts`
--
ALTER TABLE `font_group_fonts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
