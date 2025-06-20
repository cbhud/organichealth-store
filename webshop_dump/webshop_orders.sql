-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: webshop
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(35) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'2025-06-17 20:20:50','otkazano',7.99,'asdasd','asd',''),(2,3,'2025-06-17 20:20:50','poslato',18.50,'Radnicka BB','Podgorica','posaljite u paketu'),(3,2,'2025-06-17 20:20:50','otkazano',7.99,'Carine IV','Rozaje',''),(5,NULL,'2025-06-18 02:50:51','primljena',11.99,'qasdasd','Podgorica',NULL),(6,7,'2025-06-18 03:59:50','otkazana',0.00,'tu sam nedje','Podgorica',''),(7,7,'2025-06-18 04:25:46','u obradi',11.99,'asdads','Podgorica',NULL),(8,7,'2025-06-18 21:01:58','poslato',137.00,'asdasd','asdasd',''),(9,7,'2025-06-19 00:25:53','na cekanju',35.97,'titova','Budva',''),(10,7,'2025-06-19 14:55:58','na cekanju',18.50,'asdasd','Bar',''),(11,7,'2025-06-19 14:59:29','na cekanju',7.99,'asdasd','Kolašin',''),(12,7,'2025-06-19 15:00:04','na cekanju',11.99,'asdasd','Bar',''),(13,7,'2025-06-19 15:00:37','otkazano',11.99,'asdasd','Kolašin',''),(14,NULL,'2025-06-19 15:08:29','na cekanju',18.50,'asdasd','Kolašin',''),(15,NULL,'2025-06-19 15:10:36','na cekanju',37.00,'asdasdasd','Kolašin',''),(16,NULL,'2025-06-19 15:15:45','na cekanju',18.50,'asdasd','Budva',''),(17,7,'2025-06-19 20:15:18','otkazana',0.00,'asdasd','Budva',''),(18,7,'2025-06-19 20:33:17','poslat',18.50,'asdasdasd','Mojkovac',''),(19,7,'2025-06-19 21:09:27','na cekanju',7.99,'asdasd','Kolašin','asdad'),(20,7,'2025-06-19 21:12:51','u obradi',59.95,'qweqweqew','Kotor',''),(21,7,'2025-06-19 22:05:19','u obradi',38.48,'asdasd','Herceg Novi','asdasd'),(22,NULL,'2025-06-19 22:15:23','na cekanju',18.50,'asdasd','Mojkovac',''),(23,NULL,'2025-06-19 22:16:13','na cekanju',18.50,'asdasd','Bar',''),(24,NULL,'2025-06-19 22:20:11','na cekanju',18.50,'asdasd','Pljevlja',''),(25,8,'2025-06-19 22:24:53','poslat',38.48,'asdasdas','Rožaje',''),(26,8,'2025-06-19 22:59:02','poslat',38.48,'asdasd','Herceg Novi',''),(27,8,'2025-06-19 23:01:18','otkazano',38.48,'asdadsas','Kolašin',''),(28,8,'2025-06-19 23:50:08','otkazana',7.99,'asdasd','Danilovgrad',''),(29,8,'2025-06-20 00:01:14','otkazano',0.00,'asdasd','Kolašin','asdasd'),(30,7,'2025-06-20 01:13:00','u obradi',110.42,'asdasd','Danilovgrad',''),(31,10,'2025-06-20 20:15:07','u obradi',15.20,'asdasasd','Rožaje','asdasd');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-20 23:07:33
