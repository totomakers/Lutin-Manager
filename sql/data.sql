/*
SQLyog Community v12.12 (64 bit)
MySQL - 5.6.17 : Database - lutinmanager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `item` */

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(10) unsigned NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `item` */

insert  into `item`(`id`,`name`,`weight`,`active`) values (1,'Disque',151,1),(2,'Carte graphique',100,1),(3,'Carte maman',200,1),(4,'Alimentation',300,1),(5,'Processeur',120,1),(6,'Ecran',2500,1),(7,'Carte maman dsfsdfs',100,0),(8,'gotham',14,1),(9,'test',500,0),(10,'test2',800,0);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2015_12_21_124006_create_item_table',1),('2015_12_21_125052_create_user_table',1),('2015_12_21_131402_create_order_table',1),('2015_12_21_131407_create_orderRow_table',1);

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `date_validation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_user_id_foreign` (`user_id`),
  CONSTRAINT `order_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `order` */

insert  into `order`(`id`,`date`,`name`,`address`,`user_id`,`status`,`date_validation`) values (1,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',4,2,'2015-12-23 16:01:34'),(2,'2014-12-04 09:26:00','PYRENS','23 boulevard Descartes - 31000 TOULOUSE',6,2,'2015-12-23 08:04:26'),(3,'2014-12-04 10:17:00','COTON BLANC','7 Place Racine - 44000 NANTES',3,1,'0000-00-00 00:00:00'),(4,'2014-12-04 11:25:00','KIASOIF','2 Place de Monaco - 06000 NICE',4,2,'2015-12-23 15:38:05'),(5,'2014-12-04 13:03:00','PYRENS','68 promenande des Pyrennées - 64000 PAU',5,2,'2015-12-23 17:15:43'),(6,'2014-12-04 13:19:00','MBI','17 rue La Rochelle - 33000 BORDEAUX',4,2,'2015-12-23 16:07:33'),(7,'2014-12-04 13:23:00','HAL','7 rue Lavoisier - 44000 NANTES',4,2,'2015-12-23 16:35:54'),(8,'2014-12-04 13:39:00','LIB','12 rue Maison Blanche - 44000 NANTES',5,2,'2015-12-23 16:32:20'),(9,'2014-12-04 14:00:00','MAISON MS','64 rue Lavoisier - 44000 NANTES',4,2,'2015-12-23 17:22:43'),(10,'2014-12-04 14:01:00','STEP','8 impasse des Espoirs - 44800 SAINT HERBLAIN',5,2,'2015-12-23 17:04:27'),(11,'2014-12-04 14:02:00','CA','57 avenue des Acacias - 44470 CARQUEFOU',4,2,'2015-12-23 17:23:09'),(12,'2014-12-04 15:31:00','KING','2 rue des Moines - 44240 SUCE SUR ERDRE',5,2,'2015-12-23 17:23:05'),(13,'2014-12-04 15:32:00','CHEVAL BLANC','4 impasse Poilus - 444700 CARQUEFOU',5,2,'2015-12-23 17:25:42'),(14,'2014-12-04 15:39:00','ANE ROUGE','47 rue Georges Clémenceau - 76 ROUEN',4,2,'2015-12-23 17:26:11'),(15,'2014-12-04 15:57:00','JOUR BLEU','96 Place des Braves - 33000 BORDEAUX',5,2,'2015-12-23 17:27:00'),(16,'2014-12-04 16:02:00','KIDIMIEUX','12 avenue Paul Ricard - 29000 BREST',5,2,'2015-12-23 17:26:37'),(17,'2014-12-04 16:10:00','PORKIPIC','51 rue des Pastis - 56000 VANNES',5,2,'2015-12-23 17:27:14'),(18,'2014-12-04 17:35:00','DEFI','17 avenue de Boétie - 75008 PARIS',6,2,'2015-12-23 17:38:06'),(19,'2014-12-04 17:52:00','ECLAIR','9 rue des Merles - 14000 CAEN',6,1,'0000-00-00 00:00:00'),(20,'2014-12-04 18:03:00','EXEMPLE','267 Boulevard Sébastopole - 44000 NANTES',4,1,'0000-00-00 00:00:00'),(21,'2014-12-04 18:55:00','BUT','28 rue des Glacières - 75013 PARIS',7,2,'2015-12-23 17:46:50'),(22,'2014-12-04 19:35:00','ELEPHANT','234 Place Clichy - 75009 PARIS',7,2,'2015-12-23 17:47:10'),(23,'2014-12-04 19:48:00','DOCTEUR INFO','3 Boulevard des Anglais - 44000 NANTES',7,2,'2015-12-23 17:47:23'),(24,'2014-12-04 20:15:00','HAV','78 Place 50 Otages - 44000 NANTES',0,0,'0000-00-00 00:00:00'),(25,'2014-12-04 20:39:00','INFO','15 rue Mimosas - 31000 TOULOUSE',0,0,'0000-00-00 00:00:00'),(26,'2014-12-04 20:51:00','YOKO','3 rue Droite - 11100 NARBOENNE',0,0,'0000-00-00 00:00:00'),(27,'2014-12-04 21:00:00','BAT','12 avenue Pinsons - 49000 ANGERS',0,0,'0000-00-00 00:00:00'),(28,'2014-12-04 21:01:00','ANG','5 rue Lilas - 44100 NANTES',0,0,'0000-00-00 00:00:00'),(29,'2014-12-04 21:52:00','ACE','125 Place Saint Pierre - 44470 CARQUEFOU',0,0,'0000-00-00 00:00:00'),(30,'2014-12-04 22:30:00','NTP','89 avenue Charles de Gaulle - 44000 NANTES',0,0,'0000-00-00 00:00:00'),(99,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(124,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(135,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(136,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(137,'2014-12-04 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(138,'2014-12-05 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(139,'2014-12-06 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(140,'2014-12-07 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(141,'2014-12-08 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(142,'2014-12-21 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(143,'2014-12-22 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(144,'2014-12-23 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(145,'2014-12-24 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00'),(146,'2014-12-27 08:29:00','BAMBOO','112 avenues Delacroix - 44800 SAINT HERBLAIN',0,0,'0000-00-00 00:00:00');

/*Table structure for table `order_row` */

DROP TABLE IF EXISTS `order_row`;

CREATE TABLE `order_row` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_row_order_id_item_id_unique` (`order_id`,`item_id`),
  KEY `order_row_item_id_foreign` (`item_id`),
  CONSTRAINT `order_row_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  CONSTRAINT `order_row_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `order_row` */

insert  into `order_row`(`id`,`order_id`,`item_id`,`quantity`) values (1,99,2,4),(2,99,4,16),(3,2,3,24),(4,2,2,5),(5,3,3,1),(6,3,1,1),(7,3,2,3),(8,4,3,7),(9,4,1,2),(10,4,2,30),(11,5,3,10),(12,5,1,8),(13,5,2,3),(14,6,3,25),(15,6,2,8),(16,7,3,3),(17,7,1,15),(18,7,2,7),(19,8,3,8),(20,8,1,8),(21,8,2,3),(22,9,3,1),(23,9,1,15),(24,9,2,9),(25,9,4,14),(26,10,3,10),(27,10,1,8),(28,10,2,3),(29,11,3,9),(30,11,1,18),(31,11,2,12),(32,12,3,5),(33,12,1,3),(34,13,3,7),(35,13,2,25),(36,14,1,18),(37,14,2,2),(38,15,3,15),(39,15,1,8),(40,15,4,9),(41,16,3,19),(42,17,3,30),(43,17,1,4),(44,17,2,12),(45,18,1,22),(46,18,2,6),(47,19,3,10),(48,19,2,3),(49,19,4,32),(50,20,4,8),(51,21,2,44),(52,22,3,10),(53,22,1,8),(54,22,2,3),(55,23,1,17),(56,23,2,9),(57,24,3,16),(58,24,1,7),(59,24,2,21),(60,25,3,10),(61,25,1,8),(62,25,2,3),(63,26,3,14),(64,26,1,1),(65,26,2,8),(66,27,3,26),(67,28,1,8),(68,28,4,2),(69,29,3,7),(70,29,1,2),(71,29,4,5),(72,29,2,3),(73,30,3,18),(74,30,1,15),(75,30,2,9),(76,30,4,32),(77,124,2,8),(78,124,4,12),(79,1,2,4),(80,1,4,16),(81,135,2,8),(82,135,4,12),(83,136,2,8),(84,136,4,12),(85,137,2,8),(86,137,4,12),(87,138,2,8),(88,138,4,12),(89,139,2,8),(90,139,4,12),(91,140,2,8),(92,140,4,12),(93,141,2,8),(94,141,4,12),(95,143,2,8),(96,143,4,12),(97,144,2,8),(98,144,4,12),(99,145,2,8),(100,145,4,12);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sha1_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`rank`,`email`,`remember_token`,`sha1_password`,`active`) values (0,'Non assigné',0,'',NULL,'',0),(2,'Père Joël2',1,'joel.pere@nomail.com','NsHCFu1EsjzDgeLHU4tyUJdkEazKebfU4vgJYY7aAj0UgTggl7G2S802ItOV','1ca0e21d7150d86d09784f779b0d2bec37113860',1),(3,'Lutin Tom',0,'tom.lutin@nomail.com','XWAwirIU5D22orJjrY9juYO2F1g8I3NqZ1jUcWcZM9RJCNUiwMyWNN2JW0gs','7f10e4b93c1b3905e73b13061097dd262aad48e2',1),(4,'Lutin Erwan',0,'erwan.lutin@nomail.com','fbok4MWJhvhNF9izk0KpmCSpZWajU5t0KGHcYz3Szo9mpna9QUlEwNznSE9T','4f8508bccc68d0c2ff7d7d4da644e398053b2109',1),(5,'Lutin Will',0,'will.lutin@nomail.com','oHNE4mbFD5MqI9fowzPRlpN2NUxzoweu1gdrWvuZMDJFbWsOuUeU2f1xocwD','3233741c2ce3c674c46a18bd21b522a2d647eafc',1),(6,'Lutin James',0,'james.lutin@nomail.com','SUNrjxs8fPMXYQZTBAEdqpLNtc55NmmuGf40i5evpueJPlwOxqbGol1bFvp9','f069102d3f79c0d0992a51fc997b65ac052460ed',1),(7,'Lutin Jamess',0,'joel.pere@nomail.com','OJQptd8BWxSs0ku2BiTBVe0lF5nqqOsNnHyobScY5i6jpoEQvkAVV3igQa0q','65b218dc15d33bfeafd5d11d3b86a5edb386ceed',1),(9,'Père Zozo',1,'pere.zozo@nomail.com',NULL,'51df270f095554e604e100a6ac0e090ca3248c90',0),(10,'test',0,'test@test.test',NULL,'e218d126f24c3ca7d914b1d7d1076a793abd5737',0),(12,'test1',0,'test1@1.com',NULL,'b1d239ecc36c6236e40048119f286c81f974f38c',0),(13,'fgdfgfd',0,'gfdgfd@dfgfd.vom',NULL,'70c4a5037ef37faf1a935796ec517549bf547074',0),(25,'dsfsd',0,'fdsfds@fr.fr',NULL,'518bb71aab6e85cfdaf0382a1b597b2b9b64cf86',0),(26,'jjfilsjfsdli',0,'rezrze@oi.gt',NULL,'c94763b3814c3e67c838325b163544222055445f',0),(27,'fdsfsd',0,'fdsfd@kl.hg',NULL,'211b9fda5346aa1bd73abd087bf110526d8f87ee',0),(28,'dsqqsdsq',0,'dsqdsq@test.com',NULL,'4424ea790bc7e2ba0751c2e0f5740bd35bebd51f',0),(29,'fddsds',0,'dsfsdfds@gr.gt',NULL,'18a65606e52b8939ed81bdebe676f0f9de024083',0),(32,'vikings',1,'hnf@JBFGV79.FDG',NULL,'bd613fda51201900a386e302fa8167a5b1073dcf',0),(33,'Test Employe',0,'test@test.com',NULL,'4aa6c96ee145d60ace08bb598282d2e4c6adc462',0),(34,'Test Employe1',0,'test1@test.com',NULL,'b61833445e835944a9752b172bcdfbf746f54c37',0),(35,'Test Employe2',0,'test2@test.com',NULL,'0bff5a20f35fa2e7fd8c8e11994e938d077ec453',0),(36,'Test Employe3',0,'test3@test.com',NULL,'57e09cd6a2b8ae579fdb46be79cd962081d17dfe',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
