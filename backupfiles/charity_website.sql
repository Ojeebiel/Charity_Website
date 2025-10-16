-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2025 at 09:36 AM
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
-- Database: `charity_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `name`, `mobile`, `email`, `password`, `account_created`) VALUES
(4, 'OWEN GILBERT LINDO', '09196325698', 's2300105@usls.edu.ph', '$2y$10$onLCbs1/ull.qmqdGyTR8.Roscy3Yj6lZGjqkAhV5oPoCfrzJQZz6', '2025-10-13 06:16:34'),
(5, 'Juan Paolo', '09632541789', 'PaoloRathbun@gmail.com', '$2y$10$JsqJDLLKTAaXhd8TYdx74.3v.SzlepN2BG0hsRgTKWIezRM8PqWYG', '2025-10-13 06:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `fundraisers`
--

CREATE TABLE `fundraisers` (
  `fundraiser_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `amount_goal` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(200) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fundraisers`
--

INSERT INTO `fundraisers` (`fundraiser_id`, `name`, `date`, `amount_goal`, `description`, `location`, `image`, `created_at`) VALUES
(11, 'Help a Friend', '2025-10-14', 10000.00, 'Help me Please For my Education', 'Not Set', 'uploads/map.png', '2025-10-13 04:08:40'),
(16, 'Bogo City, Cebu Relief Good Operation', '2025-10-25', 50000.00, 'Please Help Our Fellow Cebuanos Who are Vicitms of the Earthquake', 'Not Set', 'uploads/Opera Snapshot_2025-10-12_181953_www.reuters.com.png', '2025-10-13 05:36:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `fundraisers`
--
ALTER TABLE `fundraisers`
  ADD PRIMARY KEY (`fundraiser_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fundraisers`
--
ALTER TABLE `fundraisers`
  MODIFY `fundraiser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
