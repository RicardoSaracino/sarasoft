-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2016 at 01:18 AM
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

DROP TABLE IF EXISTS `address`;
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

DROP TABLE IF EXISTS `company`;
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

DROP TABLE IF EXISTS `customer`;
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
(1, 1, 'Spongebob', 'Squarepants', '+16135555555', NULL, NULL, '2016-10-16 23:27:32', 1, '2016-11-04 03:42:18', 1),
(2, 2, 'Squidward', 'Tenticals', '+16137052563', NULL, 'Squidward.Tenticals@ricardosaracino.com', '2016-10-17 23:39:50', 1, '2016-10-30 04:28:19', 1),
(3, 5, 'Patrik', 'Star', '+16137257079', NULL, 'patrik.star@ricardosaracino.com', '2016-10-30 02:43:35', 1, '2016-10-30 02:43:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

DROP TABLE IF EXISTS `customer_order`;
CREATE TABLE `customer_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `order_status_code` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BKD',
  `booked_from` datetime NOT NULL,
  `booked_until` datetime NOT NULL,
  `booking_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `customer_id`, `company_id`, `referral_id`, `order_status_code`, `booked_from`, `booked_until`, `booking_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 1, 1, 'BKD', '2016-10-29 02:50:00', '2016-10-30 02:45:00', '** 2016-10-30 21:25:05 ** Ricardo Saracino\nvvv\n\n** 2016-10-30 20:39:57 ** Ricardo Saracino\nEven Newer\n\n** 2016-10-30 19:49:51 ** Ricardo Saracino\nNewer Notes\n\n** 2016-10-30 19:49:15 ** Ricardo Saracino\nNew Notewsasdf', '2016-10-29 01:57:10', 1, '2016-10-31 01:25:05', 1),
(2, 2, 1, NULL, 'BKD', '2016-10-26 00:50:00', '2016-10-29 00:50:00', '** 2016-10-31 20:50:26 ** Ricardo Saracino\nasdfasdfasdf\r\nasdfasdfasdfasdf\n** 2016-10-31 18:28:00 ** Ricardo Saracino\n** 2016-10-31 18:27:51 ** Ricardo Saracino\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-31 18:27:51 ** Ricardo Saracino\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg\n** 2016-10-30 21:09:11 ** Ricardo Saracino\nsdfgdsfgdsfg', '2016-10-31 01:09:11', 1, '2016-11-01 00:50:26', 1),
(18, 1, 1, 1, 'BKD', '2016-11-01 23:05:00', '2016-11-03 23:05:00', '\n** 2016-11-02 19:54:15 ** Ricardo Saracino\nsdfgdsfg', '2016-11-02 23:54:16', 1, '2016-11-05 04:12:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_service`
--

DROP TABLE IF EXISTS `customer_order_service`;
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
-- Table structure for table `referral`
--

DROP TABLE IF EXISTS `referral`;
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

DROP TABLE IF EXISTS `service`;
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
(1, 'Blow bubble', 'Blow bubble', '2016-11-02 01:01:54', 1, '2016-11-02 01:01:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
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
  ADD KEY `company_id` (`company_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `customer_order_service`
--
ALTER TABLE `customer_order_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- Constraints for table `customer_order_service`
--
ALTER TABLE `customer_order_service`
  ADD CONSTRAINT `customer_order_service_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `customer_order_service_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`);

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
