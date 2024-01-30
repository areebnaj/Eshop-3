-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.29 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for eshop
CREATE DATABASE IF NOT EXISTS `eshop` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `eshop`;

-- Dumping structure for table eshop.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.admin: ~0 rows (approximately)
INSERT INTO `admin` (`email`, `fname`, `lname`, `verification_code`) VALUES
	('rimasmumthasofficial@gmail.com', 'rimas', 'admin', '6581d9a0e479b');

-- Dumping structure for table eshop.brand
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_category1_idx` (`category_id`),
  CONSTRAINT `fk_brand_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.brand: ~10 rows (approximately)
INSERT INTO `brand` (`id`, `name`, `category_id`) VALUES
	(1, 'Apple', 1),
	(2, 'Samsung', 1),
	(3, 'Huawei', 1),
	(4, 'Sony', 1),
	(5, 'HTC', 1),
	(6, 'Oppo', 1),
	(7, 'Canon', 3),
	(8, 'MSI', 2),
	(9, 'Asus', 2),
	(10, 'Dell', 2);

-- Dumping structure for table eshop.brand_has_model
CREATE TABLE IF NOT EXISTS `brand_has_model` (
  `brand_id` int NOT NULL,
  `model_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_brand_has_model_model1_idx` (`model_id`),
  KEY `fk_brand_has_model_brand1_idx` (`brand_id`),
  CONSTRAINT `fk_brand_has_model_brand1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `fk_brand_has_model_model1` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.brand_has_model: ~13 rows (approximately)
INSERT INTO `brand_has_model` (`brand_id`, `model_id`, `id`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 3),
	(4, 4, 4),
	(5, 5, 5),
	(6, 6, 6),
	(7, 7, 7),
	(1, 8, 9),
	(8, 10, 14),
	(9, 11, 15),
	(7, 12, 16),
	(10, 13, 17),
	(6, 3, 18);

-- Dumping structure for table eshop.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qty` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_product1_idx` (`product_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  CONSTRAINT `fk_cart_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.cart: ~0 rows (approximately)
INSERT INTO `cart` (`id`, `qty`, `product_id`, `user_email`) VALUES
	(37, 1, 2, 'rimasmumthasofficial@gmail.com');

-- Dumping structure for table eshop.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.category: ~8 rows (approximately)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'cellphones and accessories'),
	(2, 'computers & tablets'),
	(3, 'cameras'),
	(4, 'camera drones'),
	(5, 'video game consoles'),
	(8, 'azzz'),
	(9, 'abcd'),
	(10, 'ancd');

-- Dumping structure for table eshop.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text,
  `date_time` datetime DEFAULT NULL,
  `status` int DEFAULT NULL,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chat_user1_idx` (`from`),
  KEY `fk_chat_user2_idx` (`to`),
  CONSTRAINT `fk_chat_user1` FOREIGN KEY (`from`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_chat_user2` FOREIGN KEY (`to`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.chat: ~8 rows (approximately)
INSERT INTO `chat` (`id`, `content`, `date_time`, `status`, `from`, `to`) VALUES
	(53, 'hi user', '2022-11-14 17:13:53', 1, 'rimasmumthasofficial@gmail.com', 'fortest123abc@gmail.com'),
	(54, 'hello admin', '2022-11-14 17:20:43', 1, 'fortest123abc@gmail.com', 'rimasmumthasofficial@gmail.com'),
	(56, 'how are u', '2022-11-14 17:51:01', 1, 'rimasmumthasofficial@gmail.com', 'fortest123abc@gmail.com'),
	(57, 'fine', '2022-11-14 17:51:26', 1, 'fortest123abc@gmail.com', 'rimasmumthasofficial@gmail.com'),
	(58, 'any problem', '2022-11-14 17:55:32', 1, 'rimasmumthasofficial@gmail.com', 'fortest123abc@gmail.com'),
	(59, 'nothing', '2022-11-14 17:56:09', 1, 'fortest123abc@gmail.com', 'rimasmumthasofficial@gmail.com'),
	(60, 'hii dr', '2022-11-20 23:37:57', 0, 'rimasmumthasofficial@gmail.com', 'fortest123abc@gmail.com'),
	(61, 'hii', '2022-11-23 16:42:11', 0, 'rimasmumthasofficial@gmail.com', 'fortest123abc@gmail.com');

-- Dumping structure for table eshop.city
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_district1_idx` (`district_id`),
  CONSTRAINT `fk_city_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.city: ~0 rows (approximately)
INSERT INTO `city` (`id`, `name`, `district_id`) VALUES
	(1, 'panadura', 2);

-- Dumping structure for table eshop.colour
CREATE TABLE IF NOT EXISTS `colour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.colour: ~7 rows (approximately)
INSERT INTO `colour` (`id`, `name`) VALUES
	(1, 'black'),
	(2, 'grey'),
	(3, 'gold'),
	(4, 'silver'),
	(5, 'red'),
	(6, 'blue'),
	(7, 'rose gold');

-- Dumping structure for table eshop.condition
CREATE TABLE IF NOT EXISTS `condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.condition: ~2 rows (approximately)
INSERT INTO `condition` (`id`, `name`) VALUES
	(1, 'Brand New'),
	(2, 'Used');

-- Dumping structure for table eshop.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.district: ~2 rows (approximately)
INSERT INTO `district` (`id`, `name`, `province_id`) VALUES
	(1, 'kaluthara', 1),
	(2, 'colombo', 1);

-- Dumping structure for table eshop.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `feed` text NOT NULL,
  `date` datetime NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedback_user1_idx` (`user_email`),
  KEY `fk_feedback_product1_idx` (`product_id`),
  CONSTRAINT `fk_feedback_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_feedback_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.feedback: ~23 rows (approximately)
INSERT INTO `feedback` (`id`, `type`, `feed`, `date`, `user_email`, `product_id`) VALUES
	(1, 1, '', '2022-11-05 09:52:07', 'rimasmumthasofficial@gmail.com', 8),
	(2, 3, '', '2022-11-05 09:55:11', 'rimasmumthasofficial@gmail.com', 8),
	(3, 3, '', '2022-11-05 09:56:08', 'rimasmumthasofficial@gmail.com', 5),
	(4, 2, '', '2022-11-05 10:07:20', 'rimasmumthasofficial@gmail.com', 8),
	(5, 1, '', '2022-11-05 10:10:29', 'rimasmumthasofficial@gmail.com', 8),
	(6, 1, '', '2022-11-13 11:43:21', 'rimasmumthasofficial@gmail.com', 8),
	(7, 1, '', '2022-11-13 11:43:26', 'rimasmumthasofficial@gmail.com', 8),
	(8, 2, '', '2022-11-13 11:43:58', 'rimasmumthasofficial@gmail.com', 8),
	(9, 3, '', '2022-11-13 11:44:17', 'rimasmumthasofficial@gmail.com', 8),
	(10, 1, '', '2022-11-13 12:16:17', 'rimasmumthasofficial@gmail.com', 8),
	(11, 2, '', '2022-11-13 12:17:34', 'rimasmumthasofficial@gmail.com', 8),
	(12, 1, '', '2022-11-13 12:25:20', 'rimasmumthasofficial@gmail.com', 8),
	(13, 1, '', '2022-11-13 12:36:19', 'rimasmumthasofficial@gmail.com', 8),
	(14, 1, '', '2022-11-13 12:45:43', 'rimasmumthasofficial@gmail.com', 5),
	(15, 1, '', '2022-11-13 12:45:55', 'rimasmumthasofficial@gmail.com', 5),
	(16, 2, '', '2022-11-13 12:51:39', 'rimasmumthasofficial@gmail.com', 5),
	(17, 2, '', '2022-11-13 13:31:37', 'rimasmumthasofficial@gmail.com', 2),
	(18, 1, '', '2022-11-13 13:39:37', 'rimasmumthasofficial@gmail.com', 8),
	(19, 2, '', '2022-11-13 13:40:04', 'rimasmumthasofficial@gmail.com', 8),
	(20, 3, '', '2022-11-13 13:49:06', 'rimasmumthasofficial@gmail.com', 8),
	(21, 1, 'amaizing product!', '2022-11-13 14:23:25', 'rimasmumthasofficial@gmail.com', 8),
	(22, 1, 'nice product!', '2022-11-13 14:33:33', 'rimasmumthasofficial@gmail.com', 8),
	(23, 1, 'nice product', '2022-11-20 23:32:47', 'rimasmumthasofficial@gmail.com', 8);

-- Dumping structure for table eshop.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.gender: ~2 rows (approximately)
INSERT INTO `gender` (`id`, `gender_name`) VALUES
	(1, 'male'),
	(2, 'female');

-- Dumping structure for table eshop.images
CREATE TABLE IF NOT EXISTS `images` (
  `code` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_images_product1_idx` (`product_id`),
  CONSTRAINT `fk_images_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.images: ~17 rows (approximately)
INSERT INTO `images` (`code`, `product_id`) VALUES
	('resource/mobile_images/iphone12.jpg', 1),
	('resource/mobile_images/Samsung S6.jpg', 2),
	('resource/mobile_images/huawei_p20.png', 3),
	('resource/mobile_images/xperia_10.jpg', 4),
	('resource/mobile_images/htc_u.jpg', 5),
	('resource/mobile_images/oppo_a95.png', 6),
	('resource//mobile_images//Canon EOS Black_0_634f8ab7875da.jpeg', 7),
	('resource//mobile_images//Canon EOS Black_1_634f8ab7a1046.jpeg', 7),
	('resource/mobile_images/Airpods pro 2.jpg', 8),
	('resource//mobile_images//MSI modern 14 b5m_0_6350ef8d9c2ee.jpeg', 10),
	('resource//mobile_images//MSI modern 14 b5m_1_6350ef8da8b97.jpeg', 10),
	('resource//mobile_images//Asus Vivobook 15_0_6350f21d4bc63.jpeg', 11),
	('resource//mobile_images//Asus Vivobook 15_1_6350f21d5b0fb.jpeg', 11),
	('resource//mobile_images//Canon R10_0_634d45a556370.jpeg', 12),
	('resource//mobile_images//Dell Inspiration 12_0_634e7f829b251.jpeg', 13),
	('resource//mobile_images//Oppo p20 128GB_0_634f8c0322d64.jpeg', 14),
	('resource//mobile_images//Oppo p20 128GB_1_634f8c0328d77.jpeg', 14);

-- Dumping structure for table eshop.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `total` double DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_product1_idx` (`product_id`),
  KEY `fk_invoice_user1_idx` (`user_email`),
  CONSTRAINT `fk_invoice_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_invoice_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.invoice: ~11 rows (approximately)
INSERT INTO `invoice` (`id`, `order_id`, `date`, `total`, `qty`, `status`, `product_id`, `user_email`) VALUES
	(1, '6364a570063b5', '2022-11-04 11:09:46', 20340, 1, 4, 8, 'rimasmumthasofficial@gmail.com'),
	(2, '6364aed40a9d1', '2022-11-04 11:49:36', 49350, 1, 4, 5, 'rimasmumthasofficial@gmail.com'),
	(3, '636a7ad4ada05', '2022-11-08 21:22:31', 20340, 1, 4, 8, 'rimasmumthasofficial@gmail.com'),
	(4, '636f9e1647127', '2022-11-12 18:54:25', 49350, 1, 4, 5, 'rimasmumthasofficial@gmail.com'),
	(5, '636fcf7ccba48', '2022-11-12 22:24:15', 40330, 2, 4, 8, 'rimasmumthasofficial@gmail.com'),
	(6, '63706ee140325', '2022-11-13 09:44:43', 46449, 1, 4, 2, 'rimasmumthasofficial@gmail.com'),
	(7, '63707674b9b91', '2022-11-13 10:16:27', 46449, 1, 4, 2, 'rimasmumthasofficial@gmail.com'),
	(8, '637a6aa303a6b', '2022-11-20 23:28:58', 46449, 1, 4, 2, 'rimasmumthasofficial@gmail.com'),
	(9, '637dfe6f29ac0', '2022-11-23 16:36:59', 49350, 1, 0, 5, 'rimasmumthasofficial@gmail.com'),
	(10, '63b693efe0f4b', '2023-01-05 14:41:26', 20340, 1, 0, 8, 'rimasmumthasofficial@gmail.com'),
	(11, '63b6d26e886e6', '2023-01-05 19:07:34', 46449, 1, 0, 2, 'rimasmumthasofficial@gmail.com');

-- Dumping structure for table eshop.model
CREATE TABLE IF NOT EXISTS `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.model: ~13 rows (approximately)
INSERT INTO `model` (`id`, `name`) VALUES
	(1, 'iPhone 12 '),
	(2, 'S6'),
	(3, 'P20'),
	(4, 'Xperia 10'),
	(5, 'HTC U'),
	(6, 'A95'),
	(7, 'EOS '),
	(8, 'AirPod pro'),
	(9, 'desire 626'),
	(10, 'Modern 14'),
	(11, 'vivobook 15'),
	(12, 'R10'),
	(13, 'Inspiration 12');

-- Dumping structure for table eshop.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `brand_has_model_id` int NOT NULL,
  `colour_id` int NOT NULL,
  `price` double DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `description` text,
  `title` varchar(100) DEFAULT NULL,
  `condition_id` int NOT NULL,
  `status_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `datetime_added` datetime DEFAULT NULL,
  `delivery_fee_colombo` double DEFAULT NULL,
  `delivery_fee_other` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_category1_idx` (`category_id`),
  KEY `fk_product_brand_has_model1_idx` (`brand_has_model_id`),
  KEY `fk_product_colour1_idx` (`colour_id`),
  KEY `fk_product_condition1_idx` (`condition_id`),
  KEY `fk_product_status1_idx` (`status_id`),
  KEY `fk_product_user1_idx` (`user_email`),
  CONSTRAINT `fk_product_brand_has_model1` FOREIGN KEY (`brand_has_model_id`) REFERENCES `brand_has_model` (`id`),
  CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_product_colour1` FOREIGN KEY (`colour_id`) REFERENCES `colour` (`id`),
  CONSTRAINT `fk_product_condition1` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`),
  CONSTRAINT `fk_product_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_product_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.product: ~13 rows (approximately)
INSERT INTO `product` (`id`, `category_id`, `brand_has_model_id`, `colour_id`, `price`, `qty`, `description`, `title`, `condition_id`, `status_id`, `user_email`, `datetime_added`, `delivery_fee_colombo`, `delivery_fee_other`) VALUES
	(1, 1, 1, 1, 210000, 4, 'Apple iPhone 12 pro max', 'Apple iPhone 12 256GB', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 12:20:20', 399, 799),
	(2, 1, 2, 1, 46000, 2, 'Samsung S6 ', 'Samsung S6 Gold', 2, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 13:30:45', 449, 899),
	(3, 1, 3, 1, 120000, 8, 'Huawei P20 ', 'Huawei P20 128GB', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 14:55:58', 350, 690),
	(4, 1, 4, 1, 72000, 0, 'Sony Xperia 10', 'Sony Xperia 10 64GB', 2, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 22:44:37', 0, 490),
	(5, 1, 5, 5, 49000, 0, 'HTC U', 'HTC U 128GB', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 22:47:01', 350, 750),
	(6, 1, 6, 6, 73000, 0, 'Oppo A95', 'Oppo A95', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 22:48:47', 500, 900),
	(7, 3, 7, 1, 289000, 6, 'Canon EOS', 'Canon EOS Black', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-06 22:51:47', 450, 650),
	(8, 1, 9, 1, 19990, 0, 'Airpod pro 2', 'Apple airpod pro 2', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-14 08:54:01', 350, 650),
	(10, 2, 14, 2, 200000, 10, 'modern14', 'MSI modern 14 b5m', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-17 16:59:07', 500, 900),
	(11, 2, 15, 4, 190000, 3, 'asusvivobook15', 'Asus Vivobook 15', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-17 17:15:44', 450, 790),
	(12, 3, 16, 1, 120000, 5, 'Canon R10 Camera', 'Canon R10', 2, 1, 'rimasmumthasofficial@gmail.com', '2022-10-17 17:38:05', 490, 790),
	(13, 2, 17, 6, 140000, 2, '4GB RAM || 512SSD || First owner', 'Dell Inspiration 12', 2, 1, 'rimasmumthasofficial@gmail.com', '2022-10-18 15:57:14', 350, 790),
	(14, 1, 18, 3, 89000, 2, 'Oppo p20 max lite', 'Oppo p20 128GB', 1, 1, 'rimasmumthasofficial@gmail.com', '2022-10-18 19:23:20', 345, 745);

-- Dumping structure for table eshop.profile_image
CREATE TABLE IF NOT EXISTS `profile_image` (
  `path` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_profile_image_user1_idx` (`user_email`),
  CONSTRAINT `fk_profile_image_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.profile_image: ~2 rows (approximately)
INSERT INTO `profile_image` (`path`, `user_email`) VALUES
	('profile_img/for_636365fe66899.jpeg', 'fortest123abc@gmail.com'),
	('profile_img/mohamed_637a69e95f19c.svg', 'rimasmumthasofficial@gmail.com');

-- Dumping structure for table eshop.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.province: ~0 rows (approximately)
INSERT INTO `province` (`id`, `name`) VALUES
	(1, 'Western');

-- Dumping structure for table eshop.recent
CREATE TABLE IF NOT EXISTS `recent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recent_user1_idx` (`user_email`),
  KEY `fk_recent_product1_idx` (`product_id`),
  CONSTRAINT `fk_recent_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_recent_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.recent: ~52 rows (approximately)
INSERT INTO `recent` (`id`, `user_email`, `product_id`) VALUES
	(1, 'rimasmumthasofficial@gmail.com', 12),
	(2, 'rimasmumthasofficial@gmail.com', 8),
	(3, 'rimasmumthasofficial@gmail.com', 8),
	(4, 'rimasmumthasofficial@gmail.com', 12),
	(5, 'rimasmumthasofficial@gmail.com', 8),
	(6, 'rimasmumthasofficial@gmail.com', 8),
	(7, 'rimasmumthasofficial@gmail.com', 5),
	(8, 'rimasmumthasofficial@gmail.com', 7),
	(9, 'rimasmumthasofficial@gmail.com', 11),
	(10, 'rimasmumthasofficial@gmail.com', 14),
	(11, 'rimasmumthasofficial@gmail.com', 8),
	(12, 'rimasmumthasofficial@gmail.com', 11),
	(13, 'rimasmumthasofficial@gmail.com', 14),
	(14, 'rimasmumthasofficial@gmail.com', 1),
	(15, 'rimasmumthasofficial@gmail.com', 14),
	(16, 'rimasmumthasofficial@gmail.com', 11),
	(17, 'rimasmumthasofficial@gmail.com', 8),
	(18, 'rimasmumthasofficial@gmail.com', 14),
	(19, 'rimasmumthasofficial@gmail.com', 14),
	(20, 'rimasmumthasofficial@gmail.com', 11),
	(21, 'rimasmumthasofficial@gmail.com', 11),
	(22, 'rimasmumthasofficial@gmail.com', 11),
	(23, 'rimasmumthasofficial@gmail.com', 11),
	(24, 'rimasmumthasofficial@gmail.com', 8),
	(25, 'rimasmumthasofficial@gmail.com', 14),
	(26, 'rimasmumthasofficial@gmail.com', 8),
	(27, 'rimasmumthasofficial@gmail.com', 1),
	(28, 'rimasmumthasofficial@gmail.com', 8),
	(29, 'rimasmumthasofficial@gmail.com', 8),
	(30, 'rimasmumthasofficial@gmail.com', 1),
	(31, 'rimasmumthasofficial@gmail.com', 10),
	(32, 'rimasmumthasofficial@gmail.com', 8),
	(33, 'rimasmumthasofficial@gmail.com', 8),
	(34, 'rimasmumthasofficial@gmail.com', 8),
	(35, 'rimasmumthasofficial@gmail.com', 8),
	(36, 'rimasmumthasofficial@gmail.com', 1),
	(37, 'rimasmumthasofficial@gmail.com', 5),
	(38, 'rimasmumthasofficial@gmail.com', 8),
	(39, 'rimasmumthasofficial@gmail.com', 8),
	(40, 'rimasmumthasofficial@gmail.com', 1),
	(41, 'rimasmumthasofficial@gmail.com', 8),
	(42, 'rimasmumthasofficial@gmail.com', 1),
	(43, 'rimasmumthasofficial@gmail.com', 14),
	(44, 'rimasmumthasofficial@gmail.com', 14),
	(45, 'rimasmumthasofficial@gmail.com', 8),
	(46, 'rimasmumthasofficial@gmail.com', 5),
	(47, 'rimasmumthasofficial@gmail.com', 5),
	(48, 'rimasmumthasofficial@gmail.com', 8),
	(49, 'rimasmumthasofficial@gmail.com', 8),
	(50, 'rimasmumthasofficial@gmail.com', 8),
	(51, 'rimasmumthasofficial@gmail.com', 2),
	(52, 'rimasmumthasofficial@gmail.com', 14);

-- Dumping structure for table eshop.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.status: ~2 rows (approximately)
INSERT INTO `status` (`id`, `name`) VALUES
	(1, 'Active'),
	(2, 'Deactive');

-- Dumping structure for table eshop.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `joined_date` datetime DEFAULT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.user: ~4 rows (approximately)
INSERT INTO `user` (`email`, `fname`, `lname`, `password`, `mobile`, `joined_date`, `verification_code`, `status`, `gender_id`) VALUES
	('fortest123abc@gmail.com', 'for', 'test', 'test123', '0724487083', '2022-10-08 15:44:49', NULL, 1, 1),
	('kamal123@gmail.com', 'kamal', 'perera', 'kamal899', '0786978201', '2022-11-20 23:17:36', NULL, 1, 1),
	('kamal@gmail.com', 'kamal', 'perera', 'kamal321', '0786075290', '2022-11-20 23:07:14', NULL, 1, 1),
	('rimasmumthasofficial@gmail.com', 'mohamed', 'rimas', 'rimas90', '0763942267', '2022-10-05 18:08:36', '64cccae3aac6c', 1, 1);

-- Dumping structure for table eshop.user_has_address
CREATE TABLE IF NOT EXISTS `user_has_address` (
  `user_email` varchar(100) NOT NULL,
  `city_id` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `line1` text,
  `line2` text,
  `postal_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_city_city1_idx` (`city_id`),
  KEY `fk_user_has_city_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_city_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `fk_user_has_city_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.user_has_address: ~2 rows (approximately)
INSERT INTO `user_has_address` (`user_email`, `city_id`, `id`, `line1`, `line2`, `postal_code`) VALUES
	('rimasmumthasofficial@gmail.com', 1, 1, 'eluwila', 'panadura', '12500'),
	('fortest123abc@gmail.com', 1, 5, 'gorakana', 'samagi mawath', '12502');

-- Dumping structure for table eshop.watchlist
CREATE TABLE IF NOT EXISTS `watchlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_watchlist_product1_idx` (`product_id`),
  KEY `fk_watchlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_watchlist_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_watchlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table eshop.watchlist: ~0 rows (approximately)
INSERT INTO `watchlist` (`id`, `product_id`, `user_email`) VALUES
	(47, 8, 'rimasmumthasofficial@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
images