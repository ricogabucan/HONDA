/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - rusi_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rusi_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `rusi_db`;

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `feedback` */

insert  into `feedback`(`id`,`name`,`email`,`user_id`,`message`,`rating`,`submitted_at`) values 
(13,'Teodirico J Gabucan','ricogabs075@gmail.com',NULL,'','4','2025-05-25 16:50:31');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` enum('scooters','underbones','bigbikes') NOT NULL DEFAULT 'scooters',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`description`,`price`,`main_image`,`created_at`,`category`) values 
(30,'Honda Beat',NULL,78000.00,'images/beat1.jpg','2025-05-25 15:52:01','scooters'),
(31,'Honda Click 125',NULL,85000.00,'images/click125.jpg','2025-05-25 16:11:37','scooters'),
(33,'Honda Pcx 160',NULL,135000.00,'images/pcx.jpg','2025-05-25 16:11:57','scooters'),
(34,'Honda Winner X',NULL,130000.00,'images/sniper.jpg','2025-05-25 16:12:14','underbones'),
(37,'Honda Wave RSX',NULL,65000.00,'images/wave.jpg','2025-05-25 16:13:24','underbones'),
(38,'Honda XRM125 DS',NULL,72000.00,'images/xrm.jpg','2025-05-25 16:13:50','underbones'),
(39,'Honda XL 750',NULL,598000.00,'images/xl750.jpg','2025-05-25 16:14:27','bigbikes'),
(41,'Honda X ADV',NULL,849000.00,'images/xadv.jpg','2025-05-25 16:15:08','bigbikes'),
(42,'Honda NX500',NULL,409000.00,'images/x500.jpg','2025-05-25 16:15:30','bigbikes');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`created_at`) values 
(1,NULL,'dump@gmail.com','$2y$10$thdSxi/eMn90Wu.pY5E7zecuek1IaZi3ht79V7GQ0qoJdEAw0kk6W','2025-05-22 23:03:38'),
(2,NULL,'ricogabs075@gmail.com','$2y$10$Pwb.sKJCIpDv1XONZvetwO1hImmAwqDkLwXtB6MEyUDYjaTgZoegO','2025-05-25 14:35:14');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
