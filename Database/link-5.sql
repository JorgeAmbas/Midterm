-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2021 at 09:03 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `link`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `time_log` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity`, `user_name`, `time_log`) VALUES
('Logged In', 'kaaarl25', '2021-06-15 11:16:35'),
('Signed Up', 'comrade', '2021-06-15 11:17:59'),
('Logged In', 'comrade', '2021-06-15 11:18:11'),
('Logged In', 'kaaarl25', '2021-06-15 11:18:29'),
('Logged out', 'kaaarl25', '2021-06-15 11:18:55'),
('Logged In', 'comrade', '2021-06-15 11:19:24'),
('Reset Password', 'comrade', '2021-06-15 11:19:50'),
('Logged out', 'comrade', '2021-06-15 11:19:52'),
('Logged In', 'kaaarl25', '2021-06-15 11:20:30'),
('Logged out', 'kaaarl25', '2021-06-15 11:21:19'),
('Logged In', 'kaaarl25', '2021-06-15 11:21:22'),
('Logged out', 'kaaarl25', '2021-06-15 11:22:24'),
('Logged In', 'kaaarl25', '2021-06-15 11:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `authentication_code`
--

CREATE TABLE `authentication_code` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authentication_code`
--

INSERT INTO `authentication_code` (`id`, `user_id`, `code`, `created_at`, `expiration`) VALUES
(165, 28, 651366, '2021-06-15 19:16:35', '2021-06-15 19:21:35'),
(166, 30, 419580, '2021-06-15 19:18:11', '2021-06-15 19:23:11'),
(167, 28, 538459, '2021-06-15 19:18:29', '2021-06-15 19:23:29'),
(168, 30, 814216, '2021-06-15 19:19:24', '2021-06-15 19:24:24'),
(169, 28, 772273, '2021-06-15 19:20:30', '2021-06-15 19:25:30'),
(170, 28, 622121, '2021-06-15 19:21:22', '2021-06-15 19:26:22'),
(171, 28, 709080, '2021-06-15 19:22:42', '2021-06-15 19:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertag` varchar(255) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `usertag`, `datecreated`) VALUES
(28, 'kaaarl25', '$2y$10$id3Zn3C.6XR2wuuOF5PQ1eUJjgjbFd5d5Y23CVu9dx0sfO6xPoBv6', 'karl.villanueva@cvsu.edu.ph', 'admin', '2021-06-11 06:26:21'),
(29, 'karl123', '$2y$10$0MrHONEWKDHvJuHSxuy7cu.jGszPyQxa5gWw8eup0491YHpP/1oOG', 'karl.villanueva@cvsu.edu.ph', 'admin', '2021-06-15 11:02:15'),
(30, 'comrade', '$2y$10$WD7KKefvu4JRf2vPrkpKMeZB5SospHo8HuCPLqUkHN0dKpxGlUZP6', 'karl.villanueva@cvsu.edu.ph', 'admin', '2021-06-15 11:17:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication_code`
--
ALTER TABLE `authentication_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentication_code`
--
ALTER TABLE `authentication_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
