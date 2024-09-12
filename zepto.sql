-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 06:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `game_type` varchar(255) NOT NULL,
  `board_number` int(11) NOT NULL,
  `max_players` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game_name`, `game_type`, `board_number`, `max_players`) VALUES
(1, 'Anastasia Hendricks', 'Officia quo voluptat', 337, 4),
(2, 'Xena Key', 'Natus ex vitae excep', 822, 46),
(3, 'Macon Hopkins', 'Ut corrupti dolor i', 430, 85),
(4, 'Kirestin Allison', 'Reiciendis commodo a', 82, 20),
(5, 'Sigourney Bernard', 'Do at maxime eiusmod', 376, 6),
(6, 'Lana Carson', 'Eum laborum omnis ex', 741, 19),
(7, 'Larissa Walton', 'Quos impedit distin', 746, 61),
(8, 'Xena Moses', 'Enim illum culpa au', 447, 80),
(9, 'Vladimir Kramer', 'Hic similique qui vo', 874, 43),
(10, 'Hasad Odonnell', 'Ut aut fugiat ullam ', 342, 93),
(11, 'Dai England', 'Sit soluta repellen', 193, 86),
(12, 'Holmes Silva', 'Quasi magni fugit e', 347, 56),
(13, 'Thane Hartman', 'Facere dolor saepe n', 811, 98),
(14, 'Bell Beck', 'Deleniti velit molli', 642, 37),
(15, 'Marsden Ramsey', 'Necessitatibus est s', 889, 95),
(16, 'Donna Johns', 'Fugiat officiis aut', 14, 55),
(17, 'Brian Ross', 'Beatae id delectus ', 856, 79),
(18, 'TEST GAME', 'No type', 123456, 4);

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `id` bigint(20) NOT NULL,
  `game_id` bigint(20) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `game_id`, `student_id`, `date`, `time`, `created_at`) VALUES
(1, 18, '22333', '0000-00-00', '12am', '2024-01-17 17:16:44'),
(2, 18, '123255', '0000-00-00', '12am', '2024-01-17 17:17:35'),
(3, 18, '45415', '0000-00-00', '12am', '2024-01-17 17:17:53'),
(4, 18, '64646', '0000-00-00', '12am', '2024-01-17 17:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `student_id`, `created_at`) VALUES
(1, 'Sajib', '22333', '2024-01-14 14:34:37'),
(2, 'Craig Lancaster', '123255', '2024-01-14 15:03:15'),
(3, 'fsffsdf1', '45415', '2024-01-14 15:03:57'),
(4, 'frwerwe', '64646', '2024-01-17 15:03:05'),
(5, 'regredwaf', '47799', '2024-01-17 15:03:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
