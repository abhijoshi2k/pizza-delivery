-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2020 at 09:56 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza`
--
CREATE DATABASE IF NOT EXISTS `pizza` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pizza`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `employees`:
--

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `firstname`, `surname`, `contact`) VALUES
(1, 'abhijoshi2k', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9757468857');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item` varchar(20) NOT NULL,
  `cost` int(5) NOT NULL,
  `included` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `menu`:
--

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item`, `cost`, `included`) VALUES
(3, 'Cheese Pizza', 250, 1),
(4, '5 Pepper', 350, 1),
(5, 'Mexican Green Wave', 450, 1),
(6, 'Chicken Tikka', 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_list` varchar(200) NOT NULL,
  `order_quantity` varchar(200) NOT NULL,
  `order_total` varchar(7) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `order_time` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `orders`:
--   `user_id`
--       `users` -> `id`
--

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_list`, `order_quantity`, `order_total`, `address`, `contact`, `status`, `order_time`) VALUES
(1, 2, '3 5', '1 1', '700', 'a', '9757468857', 6, '01/09/2020 10:55:36am IST'),
(2, 2, '4 5', '1 3', '1700', 'a\r\na2\r\na3', '9757468857', 4, '01/09/2020 12:34:23pm IST'),
(3, 3, '3 5', '1 6', '2950', '9/6 udyan chs\r\nnear ghatkopar depot\r\nghatkopar e\r\nmum75', '8452999719', 4, '03/09/2020 11:09:36am IST'),
(4, 2, '4 5', '1 1', '800', 'a', '9757468857', 3, '04/09/2020 12:28:25pm IST'),
(5, 3, '5', '1', '450', 'a\r\naa', '9999999999', 6, '04/09/2020 04:19:30pm IST'),
(6, 3, '3 5', '1 1', '700', 'z', '9999999999', 0, '04/09/2020 04:22:44pm IST'),
(7, 3, '3 4 5', '1 1 1', '1050', 'k', '9999999999', 0, '04/09/2020 04:24:10pm IST'),
(8, 2, '3', '1', '250', 'a\r\nz', '9757468857', 1, '07/09/2020 12:38:27pm IST');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `security_question` varchar(100) NOT NULL,
  `answer` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `surname`, `contact`, `security_question`, `answer`) VALUES
(2, 'abhi.joshi2k', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9757468857', 'Enter pass123', '32250170a0dca92d53ec9624f336ca24'),
(3, 'abhi', '32250170a0dca92d53ec9624f336ca24', 'Anj', 'J', '9999999999', 'Enter pass123', '32250170a0dca92d53ec9624f336ca24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
