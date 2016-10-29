-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2016 at 02:33 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarasoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `line_1` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_2` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_3` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_or_postalcode` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_or_province` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `line_1`, `line_2`, `line_3`, `city`, `zip_or_postalcode`, `state_or_province`, `country`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Bikinibottom', NULL, NULL, 'Bikinibottom', 'K1K1K1', 'SK', 'CA', '2016-10-16 23:27:32', NULL, '2016-10-22 21:21:15', 1),
(2, 'asdfas', 'fsadfdd', 'asdfasd', 'fsadf', 'asdfsadf', 'ON', 'CA', '2016-10-17 23:39:50', 1, '2016-10-17 23:47:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_phone` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `phone`, `alt_phone`, `email`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Spongebob', 'Squarepants', '+16135555555', NULL, NULL, '2016-10-16 23:27:32', 1, '2016-10-22 21:21:15', 1),
(2, 'Squidward', 'Tenticals', '+16137052563', NULL, NULL, '2016-10-17 23:39:50', 1, '2016-10-18 19:35:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_addresses`
--

CREATE TABLE `customers_addresses` (
  `customer_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers_addresses`
--

INSERT INTO `customers_addresses` (`customer_id`, `address_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `order_status_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BKD',
  `booked_from` datetime NOT NULL,
  `booked_until` datetime NOT NULL,
  `booking_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `started_on` date DEFAULT NULL,
  `finished_on` date DEFAULT NULL,
  `paid_on` date DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `customer_id`, `referral_id`, `order_status_code`, `booked_from`, `booked_until`, `booking_notes`, `started_on`, `finished_on`, `paid_on`, `details`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 1, 'BKD', '2016-10-30 01:55:00', '2016-10-30 02:25:00', 'User name\n\n\nUser name\nBooking notes', NULL, NULL, NULL, '', '2016-10-29 01:57:10', 1, '2016-10-29 02:27:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE `referral` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral`
--

INSERT INTO `referral` (`id`, `name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Karen Plankton', '2016-10-29 01:56:17', 1, '2016-10-29 01:56:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_password_at` datetime DEFAULT NULL,
  `salt` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_zone` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `roles`, `created_at`, `created_by`, `updated_at`, `updated_by`, `updated_password_at`, `salt`, `time_zone`, `language`) VALUES
(1, 'admin', '$2a$12$oakMxAtS3pfalU92lgWmhudPkkPHQqFYlGC0IGBSnBuxcpbJcZuLy', 'Ricardo', 'Saracino', 'ricardo.saracino@ricardosaracino.com', '["ROLE_SUPER_ADMIN"]', '2016-10-06 11:24:17', NULL, '2016-10-12 01:03:38', NULL, '2016-10-10 10:24:00', '', 'America/Toronto', 'en'),
(3, 'asdfasdf', '$2y$12$rwAQkW1HwmdGlJUkQGa85O9syG/4DnniiDJndTBh.qaWmJrJngTbO', 'asdf', 'dddd', 'asdf@asdf.ca', '["ROLE_SUPER_ADMIN"]', '2016-10-29 02:04:03', 1, '2016-10-29 02:04:03', 1, NULL, ' z£Ãõ™ ï0ãðœÌ', 'America/Toronto', 'en');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `customers_addresses`
--
ALTER TABLE `customers_addresses`
  ADD PRIMARY KEY (`customer_id`,`address_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `referral_id` (`referral_id`);

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `referral`
--
ALTER TABLE `referral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `customers_addresses`
--
ALTER TABLE `customers_addresses`
  ADD CONSTRAINT `customers_addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `customers_addresses_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Constraints for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_4` FOREIGN KEY (`referral_id`) REFERENCES `referral` (`id`);

--
-- Constraints for table `referral`
--
ALTER TABLE `referral`
  ADD CONSTRAINT `referral_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `referral_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
