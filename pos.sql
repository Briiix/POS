-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2022 at 01:48 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` tinyint(4) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `contact_number`, `address`, `is_deleted`, `created_at`) VALUES
(1, 'Juan Dela Cruz', '09123456788', 'Sobol San Fabian, Pangasinan', 0, '2022-07-23 11:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method`) VALUES
(1, 'Cash'),
(2, 'Credit');

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `id` tinyint(4) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`id`, `status`) VALUES
(1, 'Paid'),
(2, 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` smallint(6) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `supplier_id` smallint(6) NOT NULL,
  `product_price` int(22) NOT NULL,
  `expiry_date` date NOT NULL,
  `qty` varchar(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `supplier_id`, `product_price`, `expiry_date`, `qty`, `image`, `is_deleted`, `created_at`) VALUES
(1, 'Adobong Pusa', 1, 100, '2023-03-17', '0', 'cat7.jpg', 0, '2022-07-19 14:59:31'),
(2, 'Tender Juicy Hotdog', 2, 150, '2024-04-18', '3', 'YADUyl1.jpeg', 0, '2022-07-21 13:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` tinyint(4) NOT NULL,
  `product_id` tinyint(4) NOT NULL,
  `purchase_quantity` int(11) NOT NULL,
  `payment_method_id` tinyint(4) NOT NULL,
  `payment_status_id` tinyint(4) NOT NULL,
  `customer_id` tinyint(4) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `product_id`, `purchase_quantity`, `payment_method_id`, `payment_status_id`, `customer_id`, `purchase_price`, `is_deleted`, `created_at`) VALUES
(1, 1, 1, 1, 1, 1, 100, 0, '2022-07-20 13:02:13'),
(2, 1, 1, 1, 1, 1, 100, 0, '2022-07-20 11:34:35'),
(3, 1, 1, 2, 1, 1, 100, 0, '2022-07-20 12:20:10'),
(4, 1, 2, 2, 1, 1, 200, 0, '2022-07-20 14:39:51'),
(5, 1, 2, 2, 1, 1, 200, 0, '2022-07-20 14:59:31'),
(6, 2, 1, 2, 2, 1, 150, 0, '2022-07-20 13:02:22'),
(7, 2, 2, 1, 1, 0, 300, 0, '2022-07-19 16:08:38'),
(8, 2, 1, 1, 1, 0, 150, 0, '2022-07-20 12:40:30'),
(9, 2, 1, 2, 2, 1, 150, 0, '2022-07-20 12:42:31'),
(10, 2, 1, 1, 1, 0, 150, 0, '2022-07-20 13:00:21'),
(11, 2, 1, 1, 1, 0, 150, 0, '2022-07-20 13:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` tinyint(4) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `contact_number`, `address`, `is_deleted`, `created_at`) VALUES
(1, 'Jollibee Arellano', '09274113349', 'Dagupan', 0, '2022-07-19 12:42:48'),
(2, 'CDO', '09123456789', 'Cebu', 0, '2022-07-19 12:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(4) NOT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT 1,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 1, 'admin', 'admin', 'admin', 'admin'),
(2, 2, 'test', 'test', 'test', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
