-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: fdb29.awardspace.net
-- Generation Time: Nov 29, 2020 at 07:08 PM
-- Server version: 5.7.20-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3667817_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--
-- Creation: Nov 29, 2020 at 10:40 AM
-- Last update: Nov 29, 2020 at 04:27 PM
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `old_row` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `new_row` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `action`, `old_row`, `new_row`, `time_stamp`) VALUES
(1, 4, 'INSERT', NULL, '{"username": "abhi.1901", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Abhishek", "contact": "9999999998", "security_question": "pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '2020-10-26 07:03:32'),
(2, 3, 'UPDATE', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Anj", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Anj", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '2020-11-27 19:52:28'),
(3, 3, 'UPDATE', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Anj", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Anj", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '2020-11-27 19:55:35'),
(4, 3, 'UPDATE', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Anj", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '{"username": "abhi", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Abhishek", "contact": "9999999999", "security_question": "Enter pass123", "answer": "32250170a0dca92d53ec9624f336ca24"}', '2020-11-28 09:34:37'),
(5, 5, 'INSERT', NULL, '{"username": "abhi.j", "password": "32250170a0dca92d53ec9624f336ca24", "firstname": "Abhi", "contact": "9999999898", "security_question": "What is your car\'s no.", "answer": "32250170a0dca92d53ec9624f336ca24"}', '2020-11-28 10:08:23'),
(6, 6, 'INSERT', NULL, '{"answer": "cfce9735de7c3873a55331a4e74b70fc", "contact": "7208583714", "password": "a414f6ad47f8afd109019ed9a26aa354", "username": "vishak_udupa", "firstname": "Vishak", "security_question": "Who is alpha"}', '2020-11-29 12:52:12'),
(7, 3, 'UPDATE', '{"answer": "32250170a0dca92d53ec9624f336ca24", "contact": "9999999999", "password": "32250170a0dca92d53ec9624f336ca24", "username": "abhi", "firstname": "Abhishek", "security_question": "Enter pass123"}', '{"answer": "32250170a0dca92d53ec9624f336ca24", "contact": "9999999999", "password": "32250170a0dca92d53ec9624f336ca24", "username": "abhi", "firstname": "Abhishek", "security_question": "Enter pass123"}', '2020-11-29 14:15:21'),
(8, 7, 'INSERT', NULL, '{"answer": "721a4b1a92b861aca48783ecb97513c0", "contact": "9819646726", "password": "1d3f493564b605f76648a56275df7a12", "username": "ash_kod", "firstname": "Ashwini", "security_question": "What is Ashwini\'s sport?"}', '2020-11-29 14:34:17'),
(9, 8, 'INSERT', NULL, '{"answer": "2b197829d548512d1d4b8bd5c773d6c3", "contact": "9082683101", "password": "63da591ef7baa658000fba33719f6dbc", "username": "a_rao", "firstname": "Aditi", "security_question": "What is my name"}', '2020-11-29 15:48:16'),
(10, 9, 'INSERT', NULL, '{"answer": "32250170a0dca92d53ec9624f336ca24", "contact": "9799999999", "password": "32250170a0dca92d53ec9624f336ca24", "username": "abhij", "firstname": "Abhishek", "security_question": "Enter pass123"}', '2020-11-29 16:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--
-- Creation: Nov 29, 2020 at 10:40 AM
-- Last update: Nov 29, 2020 at 10:40 AM
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
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `firstname`, `surname`, `contact`) VALUES
(1, 'abhijoshi2k', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9757468857');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--
-- Creation: Nov 29, 2020 at 10:40 AM
-- Last update: Nov 29, 2020 at 02:03 PM
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item` varchar(20) NOT NULL,
  `cost` int(5) NOT NULL,
  `ingredients` varchar(150) NOT NULL,
  `type` char(1) NOT NULL,
  `img_src` varchar(50) NOT NULL,
  `included` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item`, `cost`, `ingredients`, `type`, `img_src`, `included`) VALUES
(3, 'Cheese Pizza', 250, 'Cheese, Extra Cheese', '1', 'images/cheese.jpg', 1),
(7, 'Farmhouse', 500, 'Paneer, Cheese, Red Chilli', '1', 'images/farmhouse.jpg', 1),
(8, 'Peppy Paneer', 300, 'Paneer, Black Olives, Capsicum, Pepper', '1', 'images/peppy_paneer.jpg', 1),
(9, 'Deluxe Veggie', 550, 'Capsicum, Pepper, Onions', '1', 'images/deluxe_veggie.jpg', 1),
(10, 'Corn Cheese', 450, 'Corn, Cheese, Onion', '1', 'images/corn_cheese.jpg', 1),
(11, 'Fresh Veggie', 420, 'Capsicum, Onion, Cheese', '1', 'images/fresh_veggie.jpg', 1),
(12, 'Chicken Sausage', 350, 'Chicken, Sausage, Onion', '0', 'images/chicken_sausage.jpg', 1),
(13, 'Non-Veg Supreme', 400, 'Black Olives, Mushrooms, BBQ Chicken', '0', 'images/non-veg_supreme.jpg', 1),
(14, 'Chicken Barbeque', 550, 'Pepper, Barbeque, Onion', '0', 'images/pepper_barbeque_onion.jpg', 1),
(15, 'Chicken Bominator', 750, 'Barbeque Chicken, Pepper, Chilli, Onion', '0', 'images/bominator.jpg', 1),
(16, 'Chicken Delight', 600, 'Chicken Nuggets, Corn, Olive Oil, Vishak', '0', 'images/chicken_golden_delight.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
-- Creation: Nov 29, 2020 at 10:40 AM
-- Last update: Nov 29, 2020 at 04:30 PM
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
(8, 2, '3', '1', '250', 'a\r\nz', '9757468857', 1, '07/09/2020 12:38:27pm IST'),
(9, 2, '3 4', '1 1', '600', 'lol', '9757468857', 0, '17/10/2020 11:54:57am IST'),
(10, 3, '3 4', '4 2', '1700', 'try 1', '9999999999', 0, '28/11/2020 11:57:02am IST'),
(11, 3, '3 5', '1 1', '700', 'esfadevg\r\nsv zfdv z\r\ndfv dsf ', '9999999999', 0, '28/11/2020 02:56:22pm IST'),
(12, 3, '3 5', '1 1', '700', 'sxacs', '9999999999', 5, '28/11/2020 02:58:21pm IST'),
(13, 3, '3 5', '5 1', '1700', 'Tushant\r\nKa\r\nGhar', '9999999999', 6, '28/11/2020 03:27:56pm IST'),
(14, 5, '3 4', '1 1', '600', 'zrdsgsdv', '9999999898', 3, '28/11/2020 03:44:30pm IST'),
(15, 3, '7', '1', '500', 'a', '9999999999', 6, '29/11/2020 11:27:17am IST'),
(16, 3, '3 5', '1 1', '700', 'a', '9999999999', 0, '29/11/2020 11:27:39am IST'),
(17, 3, '3 7', '1 1', '750', 'xhftnxfbxfhbgbfgbxndf', '9999999999', 0, '29/11/2020 12:06:37pm IST'),
(18, 3, '3 7', '1 1', '750', 'zgrbrfg', '9999999999', 0, '29/11/2020 12:07:34pm IST'),
(19, 6, '3 4 7', '1 1 3', '2100', 'Naiceee', '7208583714', 5, '29/11/2020 06:22:56pm IST'),
(20, 7, '3 9 13 16', '1 1 1 1', '1800', 'Blankspace', '9819646726', 5, '29/11/2020 08:05:29pm IST'),
(21, 6, '3', '2', '500', 'Kh', '7208583714', 5, '29/11/2020 09:04:16pm IST'),
(22, 8, '3 7 8 9', '1 1 1 1', '1600', 'B123 nerul', '9082683101', 5, '29/11/2020 09:19:35pm IST'),
(23, 9, '12 13 14', '1 1 1', '1300', 'Sjdjd\r\nDjsjskd', '9799999999', 5, '29/11/2020 09:58:10pm IST');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Nov 29, 2020 at 10:40 AM
-- Last update: Nov 29, 2020 at 04:27 PM
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `surname`, `contact`, `security_question`, `answer`) VALUES
(2, 'abhi.joshi2k', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9757468857', 'Enter pass123', '32250170a0dca92d53ec9624f336ca24'),
(3, 'abhi', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9999999999', 'Enter pass123', '32250170a0dca92d53ec9624f336ca24'),
(4, 'abhi.1901', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9999999998', 'pass123', '32250170a0dca92d53ec9624f336ca24'),
(5, 'abhi.j', '32250170a0dca92d53ec9624f336ca24', 'Abhi', 'Joshi', '9999999898', 'What is your car\'s no.', '32250170a0dca92d53ec9624f336ca24'),
(6, 'vishak_udupa', 'a414f6ad47f8afd109019ed9a26aa354', 'Vishak', 'Udupa', '7208583714', 'Who is alpha', 'cfce9735de7c3873a55331a4e74b70fc'),
(7, 'ash_kod', '1d3f493564b605f76648a56275df7a12', 'Ashwini', 'Kodethur ', '9819646726', 'What is Ashwini\'s sport?', '721a4b1a92b861aca48783ecb97513c0'),
(8, 'a_rao', '63da591ef7baa658000fba33719f6dbc', 'Aditi', 'Rao', '9082683101', 'What is my name', '2b197829d548512d1d4b8bd5c773d6c3'),
(9, 'abhij', '32250170a0dca92d53ec9624f336ca24', 'Abhishek', 'Joshi', '9799999999', 'Enter pass123', '32250170a0dca92d53ec9624f336ca24');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `user_delete` AFTER DELETE ON `users` FOR EACH ROW INSERT INTO audit_log (
        user_id,
        action,
        old_row,
        new_row,
        time_stamp
    )
    VALUES(
        OLD.id,
        'DELETE',
        JSON_OBJECT(
            "username", OLD.username,
            "password", OLD.password,
            "firstname", OLD.firstname,
            "contact", OLD.contact,
            "security_question",OLD.security_question,
            "answer",OLD.answer
        ),
        null,
        CURRENT_TIMESTAMP
    )
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `user_insert` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO audit_log (
        user_id,
        action,
        old_row,
        new_row,
        time_stamp
    )
    VALUES(
        NEW.id,
        'INSERT',
        null,
        JSON_OBJECT(
            "username", NEW.username,
            "password", NEW.password,
            "firstname", NEW.firstname,
            "contact", NEW.contact,
            "security_question",NEW.security_question,
            "answer",NEW.answer
        ),
        CURRENT_TIMESTAMP
    )
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `user_update` AFTER UPDATE ON `users` FOR EACH ROW INSERT INTO audit_log (
        user_id,
        action,
        old_row,
        new_row,
        time_stamp
    )
    VALUES(
        NEW.id,
        'UPDATE',
        JSON_OBJECT(
            "username", OLD.username,
            "password", OLD.password,
            "firstname", OLD.firstname,
            "contact", OLD.contact,
            "security_question",OLD.security_question,
            "answer",OLD.answer
        ),
        JSON_OBJECT(
            "username", NEW.username,
            "password", NEW.password,
            "firstname", NEW.firstname,
            "contact", NEW.contact,
            "security_question",NEW.security_question,
            "answer",NEW.answer
        ),
        CURRENT_TIMESTAMP
    )
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `contact` (`contact`);

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
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
