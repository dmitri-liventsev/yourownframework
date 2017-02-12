/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.1.19-MariaDB : Database - tactica
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tactica` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tactica`;

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL,
  `isActive` int(1) NOT NULL DEFAULT '1',
  `status` enum('not_checked','valid','invalid') NOT NULL DEFAULT 'not_checked',
  `deletedAt` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(11) NOT NULL,
  `viewCount` int(11) NOT NULL DEFAULT '0',
  `uic` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `profile` */

insert  into `profile`(`id`,`details`,`isActive`,`status`,`deletedAt`,`createdAt`,`userId`,`viewCount`,`uic`) values (1,'{\"text1\":\"text1_value_8\",\"text2\":\"text2_value\",\"text3\":\"text3_value\",\"text4\":\"text4_value\",\"text5\":\"text5_value\",\"text6\":\"text6_value\",\"t\":\"text7_value\",\"text8\":\"text8_value\",\"checkbox2\":\"on\",\"radio1\":\"1\"}',1,'invalid',NULL,'2017-02-08 21:53:20',2,44,24);
insert  into `profile`(`id`,`details`,`isActive`,`status`,`deletedAt`,`createdAt`,`userId`,`viewCount`,`uic`) values (19,'{\"text1\":\"tasdasdasd\",\"text2\":\"text2_value_2\",\"text3\":\"text3_value\",\"text4\":\"text4_value\",\"text5\":\"text5_value\",\"text6\":\"text6_value\",\"text7\":\"text7_value\",\"text8\":\"text8_value\",\"radio1\":\"2\"}',0,'valid',NULL,'2017-02-09 23:53:53',1,1,0);
insert  into `profile`(`id`,`details`,`isActive`,`status`,`deletedAt`,`createdAt`,`userId`,`viewCount`,`uic`) values (29,'{\"text1\":\"tasdasdasd2\",\"text2\":\"text2_value_2\",\"text3\":\"text3_value\",\"text4\":\"text4_value\",\"text5\":\"text5_value\",\"text6\":\"text6_value\",\"text7\":\"text7_value\",\"text8\":\"text8_value\",\"radio1\":\"2\"}',0,'valid',NULL,'2017-02-10 20:27:57',1,1,0);
insert  into `profile`(`id`,`details`,`isActive`,`status`,`deletedAt`,`createdAt`,`userId`,`viewCount`,`uic`) values (30,'{\"text1\":\"tasdasdasd2\",\"text2\":\"text2_value_2\",\"text3\":\"text3_value\",\"text4\":\"text4_value\",\"text5\":\"text5_value\",\"text6\":\"text6_value\",\"text7\":\"text7_value\",\"text8\":\"text8_value\",\"checkbox1\":\"on\",\"checkbox2\":\"on\",\"checkbox3\":\"on\",\"radio1\":\"2\"}',0,'valid',NULL,'2017-02-10 20:28:08',1,1,0);
insert  into `profile`(`id`,`details`,`isActive`,`status`,`deletedAt`,`createdAt`,`userId`,`viewCount`,`uic`) values (31,'{\"text1\":\"tasdasdasd2\",\"text2\":\"text2_value_2\",\"text3\":\"text3_value\",\"text4\":\"text4_value\",\"text5\":\"text5_value\",\"text6\":\"text6_value\",\"text7\":\"text7_value\",\"text8\":\"text8_value\",\"checkbox1\":\"on\",\"checkbox2\":\"on\",\"checkbox3\":\"on\",\"radio1\":\"2\"}',1,'valid',NULL,'2017-02-10 20:28:11',1,1,0);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `registered` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`username`,`verified`,`registered`,`last_login`) values (1,'test@test.ee','$2y$10$1pH67cRuOXICD7O6BHbsEu8tg/5xN7r51w/8hmKqfjbsdlVSr.n9S',NULL,1,1486498151,1486743891);
insert  into `users`(`id`,`email`,`password`,`username`,`verified`,`registered`,`last_login`) values (2,'test2@test.ee','$2y$10$jMi.I5EHV39AgKiw7Z6XP.L3EVzKN4AF47Dh1zARbN1RqHtPRwVda',NULL,1,1486883075,NULL);

/*Table structure for table `users_confirmations` */

DROP TABLE IF EXISTS `users_confirmations`;

CREATE TABLE `users_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users_confirmations` */

/*Table structure for table `users_remembered` */

DROP TABLE IF EXISTS `users_remembered`;

CREATE TABLE `users_remembered` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users_remembered` */

/*Table structure for table `users_resets` */

DROP TABLE IF EXISTS `users_resets`;

CREATE TABLE `users_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users_resets` */

/*Table structure for table `users_throttling` */

DROP TABLE IF EXISTS `users_throttling`;

CREATE TABLE `users_throttling` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action_type` enum('login','register','confirm_email') COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `time_bucket` int(10) unsigned NOT NULL,
  `attempts` mediumint(8) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_type_selector_time_bucket` (`action_type`,`selector`,`time_bucket`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users_throttling` */

insert  into `users_throttling`(`id`,`action_type`,`selector`,`time_bucket`,`attempts`) values (1,'register','EsoXtJryKJQ28wPgFmAwoh5SXSZuIJJnQzgBqP1AcaA=',412916,1);
insert  into `users_throttling`(`id`,`action_type`,`selector`,`time_bucket`,`attempts`) values (2,'login','EsoXtJryKJQ28wPgFmAwoh5SXSZuIJJnQzgBqP1AcaA=',412918,2);
insert  into `users_throttling`(`id`,`action_type`,`selector`,`time_bucket`,`attempts`) values (3,'login','YbF3qi7FAir0u+QxWB5/eaHTYcFDLtZGy5I24xZRoWI=',412918,1);
insert  into `users_throttling`(`id`,`action_type`,`selector`,`time_bucket`,`attempts`) values (4,'login','oxndDpBlBAXIn6hcWUNBoQ5sTeYyHe6f9YfQ63qr3rE=',412918,1);
insert  into `users_throttling`(`id`,`action_type`,`selector`,`time_bucket`,`attempts`) values (5,'register','EsoXtJryKJQ28wPgFmAwoh5SXSZuIJJnQzgBqP1AcaA=',413023,1);

/*Table structure for table `widget` */

DROP TABLE IF EXISTS `widget`;

CREATE TABLE `widget` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `uic` int(11) unsigned NOT NULL DEFAULT '0',
  `viewCount` int(11) NOT NULL DEFAULT '0',
  `lastStatus` enum('not_checked','valid') NOT NULL DEFAULT 'not_checked',
  `deletedAt` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `widget` */

insert  into `widget`(`id`,`userId`,`uic`,`viewCount`,`lastStatus`,`deletedAt`,`createdAt`) values (1,1,5,92,'valid',NULL,'2017-02-10 17:25:45');
insert  into `widget`(`id`,`userId`,`uic`,`viewCount`,`lastStatus`,`deletedAt`,`createdAt`) values (3,2,0,0,'not_checked',NULL,'2017-02-12 09:05:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
