-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 10:38 AM
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
-- Database: `homemanage_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(8,0) DEFAULT 0,
  `product_image` varchar(255) NOT NULL,
  `Detail` text NOT NULL,
  `city` text NOT NULL,
  `status_product` varchar(50) NOT NULL,
  `date_listed` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `bedroom` int(11) NOT NULL,
  `bathroom` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id_product`, `product_name`, `price`, `product_image`, `Detail`, `city`, `status_product`, `date_listed`, `address`, `bedroom`, `bathroom`, `type`) VALUES
(1001, 'บ้านเดี่ยว', 0, '', 'บ้านเดี่ยว', 'บ้านเดี่ยว', 'ยังไม่ขาย', '0000-00-00', '40/02344', 0, 0, 'บ้านเดี่ยว'),
(1011, 'บ้านไม่ไทย', 150, '', 'บ้านนี้มีผีเหมือนบ้านสอง', 'phatumthani', 'ยังไม่ขาย', '0000-00-00', '44/7845', 5, 3, 'บ้านเดี่ยว');

-- --------------------------------------------------------

--
-- Table structure for table `product_list_condo`
--

CREATE TABLE `product_list_condo` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `Detail` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `status_product` varchar(50) DEFAULT NULL,
  `date_listed` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `bedroom` int(11) DEFAULT NULL,
  `bathroom` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list_condo`
--

INSERT INTO `product_list_condo` (`id_product`, `product_name`, `price`, `product_image`, `Detail`, `city`, `status_product`, `date_listed`, `address`, `bedroom`, `bathroom`, `type`) VALUES
(2, 'บ้านให้v3', 5555.00, '', 'บ้านให้v3', '11', 'ขายแล้ว', '2024-10-08', 'บ้านให้v3', 1, 1, 'คอนโด'),
(3, 'บ้านเดี่ยว', 0.00, '', 'บ้านเดี่ยว', 'บ้านเดี่ยว', 'ยังไม่ขาย', '0000-00-00', '40/02344', 0, 0, 'คอนโด');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `urole` varchar(255) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `urole`, `time_created`) VALUES
(1, 'คณากร', 'เผยสกุล', 'meoza3x', 'markzanazer4@gmail.com', '$2y$10$8CX2E.YPoj6B/jn9bLcEju0JzfUOZpcHR9aXnohKzfidRyHZMDkNu', 'user', '2024-10-07 14:26:15'),
(2, 'คณากร', 'เผยสกุล', 'meoza5x', 'markzanazer5@gmail.com', '$2y$10$jabXj8lTyUjUYV2w6gGuEu6otiQ0P9BamDdQw9S0VChhoG.tzZSfa', 'admin', '2024-10-08 13:20:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `product_list_condo`
--
ALTER TABLE `product_list_condo`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT for table `product_list_condo`
--
ALTER TABLE `product_list_condo`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
