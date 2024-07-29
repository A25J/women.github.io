-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 26, 2024 at 06:17 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `women2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(20) NOT NULL,
  `admin_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `admin_email` varchar(20) NOT NULL,
  `admin_phone` int NOT NULL,
  `admin_profile` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'def_prfl',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_username` (`admin_username`),
  UNIQUE KEY `admin_email` (`admin_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_email`, `admin_phone`, `admin_profile`) VALUES
(1, 'alaa', '$2y$10$pIBBuBQKAsPKu63svL.VgeUUCxWR3ggRgkBy7GZ2I53dFnfw3MvSa', 'alaa@gmail.com', 81674415, 'def_prfl');

-- --------------------------------------------------------

--
-- Table structure for table `body_information`
--

DROP TABLE IF EXISTS `body_information`;
CREATE TABLE IF NOT EXISTS `body_information` (
  `customer_id` int NOT NULL,
  `height` decimal(4,0) NOT NULL,
  `weight` decimal(4,0) NOT NULL,
  `body_shape` varchar(20) NOT NULL,
  `skin_color` varchar(20) NOT NULL,
  `skin_tone` varchar(20) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `body_information`
--

INSERT INTO `body_information` (`customer_id`, `height`, `weight`, `body_shape`, `skin_color`, `skin_tone`) VALUES
(12, '165', '65', 'pear', 'pale-white', 'light'),
(13, '155', '55', 'rectangle', 'white-fair', 'fair'),
(18, '160', '50', 'hourglass', 'pale-white', 'light');

-- --------------------------------------------------------

--
-- Table structure for table `card_info`
--

DROP TABLE IF EXISTS `card_info`;
CREATE TABLE IF NOT EXISTS `card_info` (
  `card_nb` int NOT NULL,
  `name_holder` varchar(20) NOT NULL,
  `expiration_date` date NOT NULL,
  `cvv` int NOT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`card_nb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `card_info`
--

INSERT INTO `card_info` (`card_nb`, `name_holder`, `expiration_date`, `cvv`, `customer_id`) VALUES
(2147483647, 'nancy', '0000-00-00', 8465, 12);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` int NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `quantity`, `total_price`) VALUES
(31, 12, 12, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL,
  `category_image` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'def_prfl',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_image`) VALUES
(10, 'Dresses', '663b5342c7bcf.jpg'),
(11, 'Sets', '663b537bd5bc7.jpg'),
(12, 'Jeans', '663b541ee9de2.jpg'),
(13, 'Blazers', '663b54967f494.jpg'),
(14, 'Pyjamas', '663b559f92cdc.jpg'),
(15, 'T-shirts', '664d029629b1c.jpg'),
(16, 'Hoodies', '664dc69334108.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_username` varchar(20) NOT NULL,
  `customer_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_phone` int NOT NULL,
  `customer_pic` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'def_prfl.png',
  `verification_code` int NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'offline',
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_username` (`customer_username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_username`, `customer_password`, `customer_email`, `customer_phone`, `customer_pic`, `verification_code`, `verified`, `status`) VALUES
(12, 'nancyy', '$2y$10$TVrkVIpxBA5kyTJI7B607eFGaC30oh2XPSu/W0.JlFWOOmKv/S27q', 'alaajanbieh252@gmail.com', 231874653, '664f729b5d219.jpeg', 0, 1, 'offline'),
(13, 'mona', '$2y$10$LN4BReb1ayitBssDdFmqPeybQzY1Zl8nZGrPfcP90XN35SnzM6bj2', 'alaa.m.janbey@gmail.com', 81674415, 'def_prfl.png', 10657, 1, 'offline'),
(14, 'Eman', '$2y$10$0FDRZT8tEeZRVJZbsChVb.cHfrVAo3ORZJXbas6c/.PMlod6kHfJO', 'alaajanbey252@gmail.com', 81674415, 'def_prfl.png', 812064, 1, 'offline'),
(16, 'nanus', '$2y$10$ATwKWFilPxDEUWqni450rOh/8IA5gxxkzx3fGr4.I2HBqWcApuZci', '22131195@students.liu.edu.lb', 71846578, 'def_prfl.png', 766528, 0, 'offline'),
(17, 'Nancyyy', '$2y$10$CxKW3PEBAyk3tkRuPHRsTOid5r2/pOstx68NKj6OmOlxq4i1d4jB.', '22131195@students.liu.edu.lb', 71846578, '664e10e4ee8ef.jpg', 155795, 1, 'offline'),
(18, 'AMJ', '$2y$10$T.dJz94PbWtWzw22I1FzrOsYpYYQ5Vea60CwKhq69s06furkd.1.O', 'alaajanbieh252@gmail.com', 81674415, '664e493b8ea00.jpeg', 87893, 1, 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `discount_id` int NOT NULL AUTO_INCREMENT,
  `discount_description` varchar(100) NOT NULL,
  `amount` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`discount_id`),
  KEY `t6` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_description`, `amount`, `category_id`) VALUES
(94, 'Eid Discount', 15, 10),
(95, 'Eid Discount', 15, 10),
(96, 'Eid Discount', 15, 10),
(97, 'Eid Discount', 15, 10),
(98, 'Eid Discount', 15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `fashion_designer`
--

DROP TABLE IF EXISTS `fashion_designer`;
CREATE TABLE IF NOT EXISTS `fashion_designer` (
  `designer_id` int NOT NULL AUTO_INCREMENT,
  `designer_username` varchar(20) NOT NULL,
  `designer_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `designer_email` varchar(20) NOT NULL,
  `designer_phone` int NOT NULL,
  `designer_image` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'def_prfl',
  `hiredbyadmin` int NOT NULL,
  `contract_type` varchar(30) NOT NULL,
  `hiring_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`designer_id`),
  UNIQUE KEY `designer_username` (`designer_username`),
  KEY `t7` (`hiredbyadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fashion_designer`
--

INSERT INTO `fashion_designer` (`designer_id`, `designer_username`, `designer_password`, `designer_email`, `designer_phone`, `designer_image`, `hiredbyadmin`, `contract_type`, `hiring_date`) VALUES
(3, 'DES Fatima', '$2y$10$3sjdZM8FYPcviBvpfxmL6OsQepqvFnL8Fuf65fWW0dPFOnYHFax1i', 'alaajanbieh252@gmail', 81674415, '66537b3f6d58a.jpeg', 1, 'part-time-OnSite', '2024-05-26 18:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feed_id` int NOT NULL AUTO_INCREMENT,
  `feedback` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`feed_id`),
  KEY `t15` (`customer_id`),
  KEY `t16` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `in-message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `out-message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_id` int NOT NULL,
  `designer_id` int NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `in-message`, `out-message`, `customer_id`, `designer_id`) VALUES
(1, 'dsgvs', NULL, 12, 1),
(2, 'iunk\n', NULL, 12, 1),
(3, 'fghjkl', NULL, 12, 1),
(4, 'jgv', NULL, 12, 1),
(5, 'jgv', NULL, 17, 1),
(6, 'ugkc', NULL, 17, 1),
(7, 'gkdgwkec', NULL, 17, 1),
(8, 'fdg', NULL, 17, 1),
(9, 'h', NULL, 17, 1),
(10, 'hello', NULL, 17, 1),
(11, 'i am asking you an advice', NULL, 1, 1),
(12, 'can you help me in choosing a dress for my senior project?\n', NULL, 1, 1),
(13, 'hello', NULL, 1, 1),
(14, 'hello', NULL, 17, 2),
(15, NULL, 'hello', 12, 17),
(16, 'hi', NULL, 17, 2),
(17, NULL, 'hi', 12, 17),
(18, 'hru', NULL, 2, 2),
(19, NULL, 'hi', 17, 2),
(20, 'hi', NULL, 2, 2),
(21, 'hello', NULL, 2, 2),
(22, 'hi', NULL, 2, 2),
(23, NULL, 'hello', 17, 2),
(24, 'hello', NULL, 2, 1),
(25, NULL, 'can i ask', 17, 2),
(26, NULL, 'jhnkb', 17, 2),
(27, NULL, ' a', 17, 2),
(28, 'hello', NULL, 18, 1),
(29, 'i want to ask you something', NULL, 18, 1),
(30, 'i have a senior project and i don\'t know what to wear for the final presentation', NULL, 18, 1),
(31, 'can you help?', NULL, 18, 1),
(32, NULL, 'hello', 18, 2),
(33, NULL, 'I\'m here to hear from you', 18, 2),
(34, 'jvf', NULL, 12, 1),
(35, NULL, 'dsf', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_price` int NOT NULL,
  `product_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` varchar(255) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `t13` (`product_id`),
  KEY `t14` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `location`, `total_price`, `product_id`, `customer_id`, `order_status`, `order_date`, `payment_method`) VALUES
(1, 'hamarah, west bekaa', 135, 12, 12, 'Shipped', '2024-05-25 18:31:53', 'cash'),
(2, 'hamarah, west bekaa', 85, 13, 12, 'Shipped', '2024-05-25 18:33:19', 'cash'),
(3, 'hamarah, west bekaa', 85, 14, 12, 'Shipped', '2024-05-25 18:33:19', 'cash'),
(4, 'hamarah, west bekaa', 100, 12, 12, 'Shipped', '2024-05-25 18:37:00', 'credit'),
(5, 'hamarah, west bekaa', 100, 14, 12, 'Shipped', '2024-05-25 18:37:00', 'credit'),
(6, 'hamarah, west bekaa', 28, 4, 12, 'Shipped', '2024-05-25 19:45:37', 'cash'),
(7, 'hamarah, west bekaa', 28, 5, 12, 'pending', '2024-05-25 19:45:37', 'cash'),
(8, 'hamarah, west bekaa', 28, 3, 12, 'pending', '2024-05-25 19:45:37', 'cash'),
(9, 'hamarah, west bekaa', 62, 14, 12, 'pending', '2024-05-25 19:46:43', 'cash'),
(10, 'hamarah, west bekaa', 62, 3, 12, 'pending', '2024-05-25 19:46:43', 'cash'),
(11, 'hamarah, west bekaa', 55, 14, 12, 'pending', '2024-05-26 02:50:02', 'cash'),
(12, 'hamarah, west bekaa', 14, 5, 12, 'pending', '2024-05-26 02:50:57', 'cash'),
(13, 'hamarah, west bekaa', 14, 3, 12, 'pending', '2024-05-26 02:50:57', 'cash'),
(25, 'hamarah, west bekaa', 140, 14, 12, 'Shipped', '2024-05-26 05:23:01', 'cash'),
(26, 'hamarah, west bekaa', 140, 13, 12, 'pending', '2024-05-26 05:23:01', 'cash'),
(27, 'hamarah, west bekaa', 117, 14, 12, 'pending', '2024-05-26 05:31:22', 'cash'),
(28, 'hamarah, west bekaa', 117, 5, 12, 'pending', '2024-05-26 05:31:22', 'cash'),
(29, 'hamarah, west bekaa', 37, 13, 18, 'Shipped', '2024-05-26 13:46:22', 'cash'),
(30, 'hamarah, west bekaa', 37, 5, 18, 'Shipped', '2024-05-26 13:46:22', 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(30) DEFAULT NULL,
  `product_image` varchar(30) NOT NULL,
  `unit_price` decimal(6,0) NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `t3` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `unit_price`, `category_id`) VALUES
(3, 'black shirt', '664d02bef3710.jpg', '7', 15),
(4, 'beige shirt', '664d02de1787c.jpg', '7', 15),
(5, 'coffee-color', '664d02fb6d373.jpg', '7', 15),
(6, 'Pink-Hoodie', '664dc6c918606.jpg', '25', 16),
(7, 'Beige-Hoodie', '664dc70875580.jpg', '25', 16),
(8, 'NYC-Hoodie', '664dc73d8bfd9.jpg', '25', 16),
(9, 'B-Hoodie', '664dc77965da3.jpg', '25', 16),
(12, 'blue-jeans', '664dc8c144372.jpg', '45', 12),
(13, 'grey-jeans', '664dc8f5354e2.jpg', '30', 12),
(14, 'jeans', '664dc9201337e.jpg', '55', 12);

-- --------------------------------------------------------

--
-- Table structure for table `product_quantity`
--

DROP TABLE IF EXISTS `product_quantity`;
CREATE TABLE IF NOT EXISTS `product_quantity` (
  `product_name` varchar(255) NOT NULL,
  `small` int NOT NULL,
  `medium` int NOT NULL,
  `large` int NOT NULL,
  `x_large` int NOT NULL,
  `2x_large` int NOT NULL,
  `3x_large` int NOT NULL,
  PRIMARY KEY (`product_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_quantity`
--

INSERT INTO `product_quantity` (`product_name`, `small`, `medium`, `large`, `x_large`, `2x_large`, `3x_large`) VALUES
('black shirt', 6, 6, 7, 7, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

DROP TABLE IF EXISTS `specification`;
CREATE TABLE IF NOT EXISTS `specification` (
  `specification_id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(20) NOT NULL,
  `material` varchar(20) NOT NULL,
  `boycott` varchar(10) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`specification_id`),
  KEY `t5` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`specification_id`, `brand`, `material`, `boycott`, `product_id`) VALUES
(3, 'she in', 'cotton', '0', 3),
(4, 'she in', 'cotton', '0', 4),
(5, 'she in', 'cotton', '0', 5),
(6, 'Hoodiiiee', 'cotton', '0', 6),
(7, 'Hoodiiiee', 'cotton', '0', 7),
(8, 'Hoodiiiee', 'cotton', '0', 8),
(9, 'Hoodiiiee', 'cotton', '0', 9),
(10, 'Hoodiiiee', 'cotton', '0', 10),
(11, 'Hoodiiiee', 'cotton', '1', 11),
(12, 'mom-jeans', 'jeans', '0', 12),
(13, 'mom-jeans', 'jeans', '0', 13),
(14, 'mom-jeans', 'jeans', '0', 14);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE IF NOT EXISTS `warehouse` (
  `warehouse_id` int NOT NULL AUTO_INCREMENT,
  `nb_of_product` int NOT NULL,
  `dateof_last_shipment` date NOT NULL,
  `category_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `spec_id` int NOT NULL,
  PRIMARY KEY (`warehouse_id`),
  KEY `t9` (`category_id`),
  KEY `t10` (`product_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`warehouse_id`, `nb_of_product`, `dateof_last_shipment`, `category_id`, `product_name`, `spec_id`) VALUES
(4, 54, '2024-05-26', 15, 'black shirt', 4),
(5, 54, '2024-05-26', 15, 'black shirt', 4);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_specialist`
--

DROP TABLE IF EXISTS `warehouse_specialist`;
CREATE TABLE IF NOT EXISTS `warehouse_specialist` (
  `spec_id` int NOT NULL AUTO_INCREMENT,
  `spec_username` varchar(20) NOT NULL,
  `spec_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `spec_email` varchar(20) NOT NULL,
  `spec_phone` int NOT NULL,
  `hiredbyadmin` int NOT NULL,
  `contract_type` varchar(20) NOT NULL,
  `hiring_date` date NOT NULL,
  PRIMARY KEY (`spec_id`),
  UNIQUE KEY `spec_username` (`spec_username`),
  KEY `t8` (`hiredbyadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warehouse_specialist`
--

INSERT INTO `warehouse_specialist` (`spec_id`, `spec_username`, `spec_password`, `spec_email`, `spec_phone`, `hiredbyadmin`, `contract_type`, `hiring_date`) VALUES
(4, 'alaaspec', '$2y$10$Xzp1lZvWJrrLqkcprMmUUO5j9egTFZ4LkGHgbJh9NmiR1z4fLIsqK', 'alaa@gmail.com', 81674415, 2, 'part-time-s', '0000-00-00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `body_information`
--
ALTER TABLE `body_information`
  ADD CONSTRAINT `t2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discount`
--
ALTER TABLE `discount`
  ADD CONSTRAINT `t6` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fashion_designer`
--
ALTER TABLE `fashion_designer`
  ADD CONSTRAINT `t7` FOREIGN KEY (`hiredbyadmin`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `t15` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t16` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `t13` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t14` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `t3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
