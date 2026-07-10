-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 09:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g1_fashion`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `b_id` int(11) NOT NULL,
  `bill_no` int(11) NOT NULL,
  `b_date` date NOT NULL,
  `party_id` varchar(10) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_address` varchar(500) NOT NULL,
  `gst` varchar(25) NOT NULL,
  `chalan_no` varchar(50) NOT NULL,
  `c_amount` varchar(50) NOT NULL,
  `c_total_amount` varchar(50) NOT NULL,
  `d_rate` int(11) NOT NULL,
  `d_amount` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `total_gst` decimal(10,2) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `pending_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`b_id`, `bill_no`, `b_date`, `party_id`, `p_name`, `p_address`, `gst`, `chalan_no`, `c_amount`, `c_total_amount`, `d_rate`, `d_amount`, `cgst`, `sgst`, `total_gst`, `total_amount`, `paid_amount`, `pending_amount`) VALUES
(1, 15, '2026-06-20', 'A-2', 'Akshay', 'Ved road, Surat', '10APHCR2026A7K0', '20', '10.00', '200.00', 5, 13500.00, 750.00, 750.00, 1500.00, 15000, 1000, 14000),
(2, 16, '2026-07-08', 'A-2', 'Akshay', 'Ved road, Surat', '10APHCR2026A7K0', '39', '45000.00', '50440.00', 5, 2522.00, 1197.95, 1197.95, 2395.90, 50314, 5314, 45000),
(4, 17, '2026-07-08', 'H-2', 'Sarad', 'Mota Varachha', '12ARFCR5055K1A0', '42, 38', '32150, 3575', '35725.00', 5, 1786.25, 848.47, 848.47, 1696.94, 35636, 2336, 33300),
(5, 18, '2026-07-07', 'A-1', 'Shree Degrai Impex', 'Anjana farm', '27AAACR5055K1Z7', '201, 202', '321500, 354450', '675950', 5, 33797.50, 16053.81, 16053.81, 32107.63, 674260, 102336, 571924),
(6, 19, '2026-07-10', 'A-2', 'Akshay', 'Ved road, Surat', '10APHCR2026A7K0', '1210, 2547', '254225, 5025554', '5279779', 5, 263988.95, 125394.75, 125394.75, 250789.50, 5266580, 26000, 5240580);

-- --------------------------------------------------------

--
-- Table structure for table `chalan`
--

CREATE TABLE `chalan` (
  `c_id` int(11) NOT NULL,
  `chalan_no` int(11) NOT NULL,
  `c_date` date NOT NULL,
  `party_id` varchar(50) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_address` varchar(500) NOT NULL,
  `order_no` int(11) NOT NULL,
  `design_no` varchar(25) NOT NULL,
  `cut` varchar(1000) NOT NULL,
  `total_metre` varchar(100) NOT NULL,
  `rate` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chalan`
--

INSERT INTO `chalan` (`c_id`, `chalan_no`, `c_date`, `party_id`, `p_name`, `p_address`, `order_no`, `design_no`, `cut`, `total_metre`, `rate`, `amount`, `total_amount`) VALUES
(4, 28, '2026-06-02', 'A-2', 'Akshay', 'Ved road, Surat', 26, '200 / 227', '20 / 10, 20', '20 / 30', '50 / 100', '1000', 4000),
(5, 29, '2026-05-20', 'A-1', 'Shree Degrai Impex', 'Anjana farm', 29, '220 / 227', '20, 40, 10, 20, 10, 50, 20 / 10, 20', '170 / 30', '195 / 100', '33150', 36150),
(6, 30, '2026-05-13', 'A-1', 'Shree Degrai Impex', 'Anjana farm', 50, '220 / 227', '20, 40, 10, 20, 10, 50, 20 / 10, 20', '170 / 30', '195 / 100', '33150 / 3000', 36150),
(13, 36, '2026-06-18', 'A-2', 'Akshay', 'Ved road, Surat', 0, '201', '25', '20', '100', '2000', 2000),
(14, 37, '2026-06-18', 'A-2', 'Akshay', 'Ved road, Surat', 29, '227 / 200', '10, 20 / 20', '30 / 20', '100 / 50', '3000 / 1000', 4000),
(15, 38, '2026-06-18', 'H-2', 'Sarad', 'Mota Varachha', 52, '200 / 227', '20 / 10, 20', '20 / 30', '50 / 100', '1000 / 3000', 4000),
(16, 39, '2026-06-18', 'A-2', 'Akshay', 'Ved road, Surat', 0, '200 / 125', '20 / 100, 200', '20 / 300', '50 / 150', '1000 / 45000', 46000),
(17, 41, '2026-06-10', 'A-1', 'Shree Degrai Impex', 'Anjana farm', 25, '201 / 227', '25 / 10, 20', '20 / 30', '100 / 100', '2000 / 3000', 5000),
(18, 42, '2026-07-03', 'H-2', 'Sarad', 'Mota Varachha', 0, '220', '20, 40, 10, 20, 10, 50, 20', '170', '195', '33150', 33150);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `i_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `order_no` int(11) NOT NULL,
  `party_id` varchar(50) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `card_no` int(11) NOT NULL,
  `design_no` int(10) NOT NULL,
  `details` varchar(500) NOT NULL,
  `fabric` varchar(50) NOT NULL,
  `cut` varchar(100) NOT NULL,
  `total_metre` int(11) NOT NULL,
  `matching_no` varchar(100) NOT NULL,
  `total_matching` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`i_id`, `date`, `order_no`, `party_id`, `p_name`, `card_no`, `design_no`, `details`, `fabric`, `cut`, `total_metre`, `matching_no`, `total_matching`, `rate`, `amount`, `status`) VALUES
(1, '2026-05-16', 10, 'A-2', 'Akshay', 8, 200, '250 - small panno', 'Chinon', '20', 20, '5', 1, 50, 1000, 'Pending'),
(2, '2026-05-01', 11, 'A-1', 'Shree Degrai Impex', 9, 201, '400 - big panno', 'Jimmi chu', '25', 20, '5', 1, 100, 2000, 'Complete'),
(7, '2026-06-07', 16, 'A-1', 'Shree Degrai Impex', 14, 227, '400 panno', 'Zimmichu', '10, 20', 30, '2, 20', 2, 100, 3000, 'Pending'),
(8, '2026-06-07', 17, 'H-2', 'Sarad', 15, 220, '250 panno', 'Zimmichu', '20, 40, 10, 20, 10, 50, 20', 170, '10, 20, 15, 12, 2, 3, 5', 7, 195, 33150, 'Cancel'),
(10, '2026-06-13', 18, 'A-2', 'Akshay', 16, 125, '400 - big panno', 'Jimmi chu', '100, 200', 300, '10, 20', 2, 150, 45000, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `mobile_1` varchar(15) NOT NULL,
  `mobile_2` varchar(15) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `name`, `mobile_1`, `mobile_2`, `address`, `image`, `username`, `password`) VALUES
(1, 'HARSH NILESH VEKARIYA', '6564654165', '25896170', 'SURAT (M CORP.) (PART) 34 SHREE NARAYAN NAGAR', '', 'Admin', 'Admin123'),
(2, 'hasmukhbhai', '9876543210', '77896544130', 'Varachha', '', 'hasmukhbhai', 'hasmukhbhai');

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `p_id` int(11) NOT NULL,
  `party_id` varchar(10) NOT NULL,
  `p_name` varchar(25) NOT NULL,
  `gst` varchar(25) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `p_address` varchar(250) NOT NULL,
  `pending_amount` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`p_id`, `party_id`, `p_name`, `gst`, `email_id`, `mobile_no`, `p_address`, `pending_amount`, `total_amount`) VALUES
(1, 'A-1', 'Shree Degrai Impex', '27AAACR5055K1Z7', 'shree_degrai_impex@gmail.com', '9876543210', 'Anjana farm', 0, 0),
(2, 'A-2', 'Akshay', '10APHCR2026A7K0', 'akki@gmail.com', '7043772329', 'Ved road, Surat', 0, 0),
(6, 'H-2', 'Sarad', '12ARFCR5055K1A0', 'sarad@gmail.com', '8527419630', 'Mota Varachha', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `mobile_1` varchar(15) NOT NULL,
  `mobile_2` varchar(15) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `img` varchar(10000) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`owner_id`, `name`, `mobile_1`, `mobile_2`, `address`, `img`, `user_name`, `pass`) VALUES
(1, 'HARSH NILESH VEKARIYA', '6564654165', '25896170', 'SURAT (M CORP.) (PART) 34 SHREE NARAYAN NAGAR', '', 'admin', 'admin'),
(2, 'hasmukhbhai', '9876543210', '77896544130', 'Varachha', '', 'hasmukhbhai', 'hasmukhbhai'),
(5, 'test', '9638527410', '9874563210', 'test12\r\n', '', 'admin', 'test132');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `chalan`
--
ALTER TABLE `chalan`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chalan`
--
ALTER TABLE `chalan`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
