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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Milan','Jovanovic','$2y$10$ABmvqMO3jGrUI1vDB6mOuOuUP.ubvBMOrqn/1S7kj7V2Tg7tdCqFO','milan@gmail.com','+38267111222','user'),(2,'Ana','Petrovic','$2y$10$ABmvqMO3jGrUI1vDB6mOuOuUP.ubvBMOrqn/1S7kj7V2Tg7tdCqFO','ana@gmail.com','+38267122334','user'),(3,'Petar','Markovic','$2y$10$ABmvqMO3jGrUI1vDB6mOuOuUP.ubvBMOrqn/1S7kj7V2Tg7tdCqFO','petarm@gmail.com','+38267987654','user'),(7,'Amer','Hot','$2y$10$/FzlYPC.zQbcqjjhSFX.1udlNJhQc9X3J0it0xzuq4Dl1VQEkqm5C','admin@admin.admin','068160122','admin'),(8,'ides','gasasd','$2y$10$LZPYv.C8n8kgK7VanxuKjOOif85Q0ISmSvZJNzPnGotGb3VGyJRyu','qwerty@qwerty.qwerty1','123123123','user'),(9,'Marko','Mirkovic','$2y$10$72TL4zOvCkFT0etANXZlZOJXensxdrFKqKUJelLZQNBUK2DYWBYwe','marko.m@gmail.com','123123123','user'),(10,'Pero','Perovic','$2y$10$0Sk9U3/qhk.2GH54/DK2GuvxUnJWqiSL8SHWJZPqN2yTKfiUoOu9u','pero@gmail.com','123123123','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
