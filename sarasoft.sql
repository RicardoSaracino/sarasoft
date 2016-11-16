-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2016 at 01:16 AM
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
CREATE DATABASE IF NOT EXISTS `sarasoft` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sarasoft`;

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
(2, 'asdfas', 'fsadfdd', 'asdfasd', 'fsadf', 'K1K1K1', 'ON', 'CA', '2016-10-17 23:39:50', 1, '2016-10-30 04:26:54', 1),
(4, '2990 Islington Ave', '978', NULL, 'North York', 'K2E7B4', 'ON', 'CA', '2016-10-30 01:06:17', 1, '2016-10-30 01:06:17', 1),
(5, '120 Conch Street', NULL, NULL, 'Bikini Bottom', 'K1K1K1', 'ON', 'CA', '2016-10-30 02:43:35', 1, '2016-10-30 02:43:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_phone` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `address_id`, `name`, `phone`, `alt_phone`, `email`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 'Krusty Crab', '+16135555555', NULL, 'crusty.crab@ricardosaracino.com', '2016-10-30 01:06:17', 1, '2016-10-30 01:06:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
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

INSERT INTO `customer` (`id`, `address_id`, `first_name`, `last_name`, `phone`, `alt_phone`, `email`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Spongebob', 'Squarepants', '+16135555555', NULL, NULL, '2016-10-16 23:27:32', 1, '2016-11-12 03:09:15', 1),
(2, 2, 'Squidward', 'Tenticals', '+16137052563', NULL, 'Squidward.Tenticals@ricardosaracino.com', '2016-10-17 23:39:50', 1, '2016-10-30 04:28:19', 1),
(3, 5, 'Patrik', 'Star', '+16137257079', NULL, 'patrik.star@ricardosaracino.com', '2016-10-30 02:43:35', 1, '2016-10-30 02:43:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booked_from` datetime NOT NULL,
  `booked_until` datetime NOT NULL,
  `booking_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `progress_started_at` datetime DEFAULT NULL,
  `progress_notes` text COLLATE utf8mb4_unicode_ci,
  `completed_at` datetime DEFAULT NULL,
  `completion_notes` text COLLATE utf8mb4_unicode_ci,
  `cancelled_on` datetime DEFAULT NULL,
  `cancellation_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `customer_id`, `company_id`, `referral_id`, `status`, `booked_from`, `booked_until`, `booking_notes`, `progress_started_at`, `progress_notes`, `completed_at`, `completion_notes`, `cancelled_on`, `cancellation_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 1, 1, 'customerOrder.status.booked', '2016-11-24 02:10:00', '2016-12-01 02:10:00', '\n** 2016-10-30 21:25:05 ** Ricardo Saracino\nvvv\n\n** 2016-10-30 20:39:57 ** Ricardo Saracino\nEven Newer\n\n** 2016-10-30 19:49:51 ** Ricardo Saracino\nNewer Notes\n\n** 2016-10-30 19:49:15 ** Ricardo Saracino\nNew Notewsasdf', NULL, '', NULL, '', '2016-11-17 19:00:00', '\n** 2016-11-15 14:08:23 ** Ricardo Saracino\nasdfasdfasdf', '2016-10-29 01:57:10', 1, '2016-11-15 19:48:14', 1),
(2, 2, 1, NULL, 'customerOrder.status.complete', '2016-11-15 02:05:00', '2016-11-18 02:05:00', '\n** 2016-10-31 20:50:26 ** Ricardo Saracino\nasdfasdfasdf\r\nasdfasdfasdfasdf\n** 2016-10-31 18:28:00 ** Ricardo Saracino\n** 2016-10-31 18:27:51 ** Ricardo Saracino\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-31 18:27:51 ** Ricardo Saracino\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg', '2016-11-15 21:10:00', '\n** 2016-11-15 16:09:41 ** Ricardo Saracino\ndsfgsdfgdsfg', '2016-11-15 22:00:00', '** 2016-11-15 17:01:48 ** Ricardo Saracino\nCompleted asdfasdf', NULL, '', '2016-10-31 01:09:11', 1, '2016-11-15 22:01:48', 1),
(18, 1, 1, 1, 'customerOrder.status.inprogress', '2016-11-01 23:05:00', '2016-11-03 23:05:00', '\n** 2016-11-02 19:54:15 ** Ricardo Saracino\nsdfgdsfg', '2016-11-09 00:00:00', '', NULL, '', NULL, '', '2016-11-02 23:54:16', 1, '2016-11-05 04:12:29', 1),
(19, 1, 1, 1, 'customerOrder.status.cancelled', '2016-11-15 22:50:00', '2016-11-16 22:50:00', '\n** 2016-11-15 17:52:11 ** Ricardo Saracino\ndgdgdg', NULL, NULL, NULL, NULL, '2016-11-17 22:55:00', '** 2016-11-15 17:55:34 ** Ricardo Saracino\nxvxvxv', '2016-11-15 22:52:11', 1, '2016-11-15 22:55:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_product`
--

CREATE TABLE `customer_order_product` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `comments` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_service`
--

CREATE TABLE `customer_order_service` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `comments` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_order_service`
--

INSERT INTO `customer_order_service` (`id`, `customer_order_id`, `service_id`, `quantity`, `comments`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 18, 1, 3, '2bdffgdfghdgfs', '2016-11-02 23:54:16', 1, '2016-11-05 04:12:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_status_history`
--

CREATE TABLE `customer_order_status_history` (
  `id` int(11) NOT NULL,
  `customer_order_id` int(11) NOT NULL,
  `old_status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_order_status_history`
--

INSERT INTO `customer_order_status_history` (`id`, `customer_order_id`, `old_status`, `new_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'customerOrder.status.booked', 'customerOrder.status.cancelled', '2016-11-15 19:08:23', 1, '2016-11-15 19:08:23', 1),
(2, 1, 'customerOrder.status.cancelled', 'customerOrder.status.booked', '2016-11-15 19:47:55', 1, '2016-11-15 19:47:55', 1),
(3, 1, 'customerOrder.status.booked', 'customerOrder.status.cancelled', '2016-11-15 19:48:14', 1, '2016-11-15 19:48:14', 1),
(4, 2, 'customerOrder.status.booked', 'customerOrder.status.inprogress', '2016-11-15 21:09:41', 1, '2016-11-15 21:09:41', 1),
(5, 2, 'customerOrder.status.inprogress', 'customerOrder.status.complete', '2016-11-15 22:01:48', 1, '2016-11-15 22:01:48', 1),
(6, 19, 'customerOrder.status.booked', 'customerOrder.status.cancelled', '2016-11-15 22:55:34', 1, '2016-11-15 22:55:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 'Krabby Patty', 'Krabby Patty', '2016-11-14 00:53:35', 1, '2016-11-14 00:53:35', 1);

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
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Blow Bubble', 'Blow Bubble', '2016-11-02 01:01:54', 1, '2016-11-14 00:53:21', 1);

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
(1, 'admin', '$2y$12$X5G9iyRDSEvzZcxW1krlXu.ZD28zzXluQUiqWlg7YjCxRJVoOVwui', 'Ricardo', 'Saracino', 'ricardo.saracino@ricardosaracino.com', '["ROLE_SUPER_ADMIN"]', '2016-10-06 11:24:17', NULL, '2016-11-13 02:31:00', 1, '2016-11-13 02:31:00', 'ÉR$Ÿ‘5Ýè8!o‡h+', 'America/Toronto', 'en'),
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
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `referral_id` (`referral_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `customer_order_product`
--
ALTER TABLE `customer_order_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_order_id` (`customer_order_id`,`product_id`) USING BTREE,
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `customer_order_service`
--
ALTER TABLE `customer_order_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_order_id` (`customer_order_id`,`service_id`) USING BTREE,
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `customer_order_status_history`
--
ALTER TABLE `customer_order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `customer_order_id` (`customer_order_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `referral`
--
ALTER TABLE `referral`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `customer_order_product`
--
ALTER TABLE `customer_order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_order_service`
--
ALTER TABLE `customer_order_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_order_status_history`
--
ALTER TABLE `customer_order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `referral`
--
ALTER TABLE `referral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
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
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `company_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_4` FOREIGN KEY (`referral_id`) REFERENCES `referral` (`id`),
  ADD CONSTRAINT `customer_order_ibfk_5` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- Constraints for table `customer_order_product`
--
ALTER TABLE `customer_order_product`
  ADD CONSTRAINT `customer_order_product_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`id`),
  ADD CONSTRAINT `customer_order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `customer_order_product_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_product_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `customer_order_service`
--
ALTER TABLE `customer_order_service`
  ADD CONSTRAINT `customer_order_service_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `customer_order_status_history`
--
ALTER TABLE `customer_order_status_history`
  ADD CONSTRAINT `customer_order_status_history_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`id`),
  ADD CONSTRAINT `customer_order_status_history_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_status_history_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `referral`
--
ALTER TABLE `referral`
  ADD CONSTRAINT `referral_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `referral_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `service_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
