-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2022 at 07:12 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(30) NOT NULL,
  `supply_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `stock_type` tinyint(1) NOT NULL COMMENT '1= in , 2 = used',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `supply_id`, `qty`, `stock_type`, `date_created`) VALUES
(5, 4, 2, 1, '2022-01-06 14:41:41'),
(6, 5, 5, 1, '2022-01-08 11:36:42'),
(7, 4, 11, 1, '2022-01-08 23:59:21'),
(8, 12, 11, 1, '2022-01-09 07:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `laundry_categories`
--

CREATE TABLE `laundry_categories` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_categories`
--

INSERT INTO `laundry_categories` (`id`, `name`, `price`) VALUES
(11, '(SERVICE) Ironing', 25),
(12, '(SERVICE) Wash and Dry', 130),
(13, '(SERVICE) Hand Wash Only', 75),
(14, '(SERVICE) Fold Only', 25),
(15, '(SERVICE) Wash, Dry, and Fold', 155),
(16, '(SERVICE) Hand Wash and Dry', 140),
(17, '(PRODUCT) Liquid Detergent', 15),
(18, '(PRODUCT) Fabric Softener', 14),
(19, '(PRODUCT) Bleach', 18),
(20, '(PRODUCT) Plastic Bag', 10);

-- --------------------------------------------------------

--
-- Table structure for table `laundry_items`
--

CREATE TABLE `laundry_items` (
  `id` int(30) NOT NULL,
  `laundry_category_id` int(30) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `laundry_id` int(30) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_items`
--

INSERT INTO `laundry_items` (`id`, `laundry_category_id`, `weight`, `laundry_id`, `unit_price`, `amount`) VALUES
(100, 19, '1.00', 75, '18.00', '18.00'),
(101, 15, '2.00', 75, '155.00', '310.00'),
(102, 17, '10.00', 75, '15.00', '150.00');

-- --------------------------------------------------------

--
-- Table structure for table `laundry_list`
--

CREATE TABLE `laundry_list` (
  `id` int(30) NOT NULL,
  `customer_name` text NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `contact` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1 = ongoing,2= ready,3= claimed',
  `queue` int(30) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `pay_status` tinyint(1) DEFAULT 0,
  `amount_tendered` decimal(10,2) NOT NULL,
  `amount_change` decimal(10,2) NOT NULL,
  `remarks` text NOT NULL,
  `washing_id` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laundry_list`
--

INSERT INTO `laundry_list` (`id`, `customer_name`, `first_name`, `last_name`, `customer_address`, `contact`, `status`, `queue`, `total_amount`, `pay_status`, `amount_tendered`, `amount_change`, `remarks`, `washing_id`, `date_created`) VALUES
(74, '', 'John Joshua', 'Mendoza', '152 P Aquino avenue', '09471691559', 3, 1, '0.00', 1, '180.00', '11.00', 'babalikan ko mamaya', 'Washing Machine No. 4', '2022-01-09 07:22:40'),
(75, '', 'John Joshua', 'Mendoza', '152 P Aquino avenue', '09471691559', 3, 2, '478.00', 1, '300.00', '67.00', 'babalikan ko bukas', 'Washing Machine No. 5', '2022-01-01 07:55:13'),
(76, '', 'kevin', 'Delos Santos', 'Letre Malabon', '09235351919', 0, 3, '14.00', 1, '150.00', '136.00', 'fhfgh', 'Dryer Machine No. 1', '2022-01-09 09:45:38'),
(77, '', 'Daniel', 'Demdam', '152 P Aquino avenue', '09072633964', 2, 4, '0.00', 1, '200.00', '42.00', 'will be back at 5pm', 'Washing Machine No. 2', '2022-01-09 13:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `supply_list`
--

CREATE TABLE `supply_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supply_list`
--

INSERT INTO `supply_list` (`id`, `name`) VALUES
(4, '(FABRIC SOFTENER) Downy Fashion'),
(5, '(FABRIC SOFTENER) Downy Sunrise'),
(8, '(LIQUID DETERGENT) Breeze'),
(9, '(LIQUID DETERGENT) Tide'),
(10, '(LIQUID DETERGENT) Ariel'),
(11, '(BLEACH) Zonrox'),
(12, '(BLEACH) Clorox'),
(13, '(FABRIC SOFTENER) Surf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_contact` varchar(55) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `first_name`, `last_name`, `image`, `user_contact`, `user_address`, `type`) VALUES
(18, '', 'JoshAdmin01', 'admin123', 'John Joseph', 'Mendoza', 'https://firebasestorage.googleapis.com/v0/b/laundrytech-b8bc1.appspot.com/o/images%2FJoshAdmin01?alt=media&token=29eceee6-ab7a-4ab8-88d4-dc8be0b4ae57', '09471691559', '152 P Aquino avenue, Tonsuya Malabon City', 1),
(19, '', 'RhayzStaff', 'Staff123', 'Rhayz', 'Bautista', 'https://firebasestorage.googleapis.com/v0/b/laundrytech-b8bc1.appspot.com/o/images%2FRhayzStaff?alt=media&token=b543620f-cbca-4569-bb2e-f39ce43a0dd2', '09276428587', '310 MALVAR ST. TONDO MANILA', 2),
(20, '', 'ReynaldoAdmin01', 'admin123', 'Reynaldo', 'Pabilico', 'https://firebasestorage.googleapis.com/v0/b/laundrytech-b8bc1.appspot.com/o/images%2FReynaldoAdmin01?alt=media&token=94d97403-e3ff-4ccb-860d-bdeace2e62a3', '09958266668', '#136 Maria Clara St., 7th Avenue East, Brgy .111, Grace Park Caloocan City', 1),
(21, '', 'CarlStaff', 'Staff123', 'Carl Troy', 'Abad', 'https://firebasestorage.googleapis.com/v0/b/laundrytech-b8bc1.appspot.com/o/images%2FCarlStaff?alt=media&token=09704f40-001c-4f75-a58b-351a93b031f3', '09218984719', 'Blk 9 Lot 41 4th Street Tañong Malabon City', 2);

-- --------------------------------------------------------

--
-- Table structure for table `washing_list`
--

CREATE TABLE `washing_list` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `washing_list`
--

INSERT INTO `washing_list` (`id`, `name`, `status`) VALUES
(1, 'Washing Machine No. 1', 'Active'),
(2, 'Washing Machine No. 2', 'Active'),
(3, 'Washing Machine No. 3', 'Active'),
(12, 'Washing Machine No. 4', 'Active'),
(13, 'Washing Machine No. 5', 'In Used'),
(15, 'Dryer Machine No. 1', 'In Used'),
(16, 'Dryer Machine No. 2', 'Active'),
(17, 'Dryer Machine No. 3', 'Active'),
(18, 'Dryer Machine No. 4', 'Active'),
(19, 'Dryer Machine No. 5', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_categories`
--
ALTER TABLE `laundry_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_items`
--
ALTER TABLE `laundry_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_list`
--
ALTER TABLE `laundry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_list`
--
ALTER TABLE `supply_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `washing_list`
--
ALTER TABLE `washing_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laundry_categories`
--
ALTER TABLE `laundry_categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `laundry_items`
--
ALTER TABLE `laundry_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `laundry_list`
--
ALTER TABLE `laundry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `supply_list`
--
ALTER TABLE `supply_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `washing_list`
--
ALTER TABLE `washing_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
