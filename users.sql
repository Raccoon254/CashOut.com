-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 08:30 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cash`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `referral_code` varchar(6) NOT NULL,
  `balance` int(11) DEFAULT 0,
  `referred_by` varchar(6) DEFAULT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` varchar(100) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `referral_code`, `balance`, `referred_by`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@cashout.com', 'admin', '', 0, NULL, 'user', '2023-01-12 05:42:10'),
(3, 'admin2', 'admin2@cashout.com', 'admin', '4GNC4K', 200, NULL, 'user', '2023-01-12 05:42:10'),
(4, 'test', 'test@cashout.com', 'test', 'TF0OWL', 80, NULL, 'user', '2023-01-12 05:42:10'),
(5, 'test2', 'test2@cashout.com', 'test', 'VHDMP9', 0, 'TF0OWL', 'admin', '2023-01-12 05:42:10'),
(6, 'test3', 'test3@cashout.com', 'test', '2R8B6C', 0, 'TF0OWL', 'user', '2023-01-12 06:10:43'),
(7, 'test4', 'test4@cashout.com', 'test', 'HYJCHP', 0, '', 'user', '2023-01-12 07:43:18'),
(8, 'test5', 'test5@cashout.com', 'test', 'TW3BKJ', 0, '', 'user', '2023-01-12 07:46:14'),
(9, 'test6', 'test6@cashout.com', 'test', 'XHHWYU', 0, '', 'user', '2023-01-12 07:50:54'),
(10, 'test7', 'test7@cashout.com', 'test', 'Y7Z01V', 0, '', 'user', '2023-01-12 07:52:00'),
(11, 'test8', 'test8@cashout.com', 'test', '8LFM1T', 0, '', 'user', '2023-01-12 07:57:04'),
(12, 'admin3', 'admin3@cashout.com', 'admin', 'WUG2J6', 0, '', 'user', '2023-01-12 08:00:56'),
(13, 'admin4', 'admin4@cashout.com', 'admin', 'NYY6VS', 0, '', 'user', '2023-01-12 21:25:47'),
(14, 'admin5', 'admin5@cashout.com', 'admin', 'ZOZJ0A', 50, '4GNC4K', 'user', '2023-01-12 22:07:24'),
(15, 'success', 'success@cashout.com', 'succsess', 'CK7JU1', 0, 'ZOZJ0A', 'user', '2023-01-12 22:09:33'),
(16, 'admin', 's@egd.dud', 'a', 'F563SR', 0, '', 'user', '2023-01-12 22:14:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
