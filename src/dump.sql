-- MySQL dump 10.13  Distrib 9.2.0, for Linux (aarch64)
--
-- Host: localhost    Database: time_pass
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_username` varchar(100) NOT NULL,
  `recipient_username` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `comment` text,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,'om','aditya',10.00,'hey take this money boy','2025-03-17 12:07:21'),(2,'om','ankit',20.00,'le le paise bhikari','2025-03-17 12:07:49'),(3,'ankit','om',10.00,'nahi chahiye tera paisa','2025-03-17 12:09:12'),(4,'rajarshi','om',5.00,'hey take this','2025-03-17 15:36:43'),(5,'aviraj','om',10.00,'hey omkar take this','2025-03-17 15:39:49'),(6,'gnani','om',30.00,'hey om take this','2025-03-17 15:44:09'),(7,'gnani','rajarshi',30.00,'hey raj take this','2025-03-17 15:44:27');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_image` blob,
  `biography` varchar(500) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '100.00',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('aditya','adi@gmail.com','$2y$12$zQHJ58IorHJ6gOORQT4IJOb/qPp0IKpks5qQJidwtaRtEOein2fsG',_binary 'uploads/captainamerica.jpg','hey aditya her',130.00),('ankit','ankit@gmail.com','$2y$12$RLBFjIvfxv2fFpUHZ7fn2eCupvY59rY3Q2fEBFQ7sMNYKKFZ1OKq2',_binary 'uploads/captainamerica.jpg','',90.00),('aviraj','avi@gmail.com','$2y$12$dMfbr/oRd9kuAz8iClbCjubT9TElAh.nePRZOnAa9/xBFCqiBqNyO',_binary 'uploads/emraan.jpg','hey aviraJ here',90.00),('gnani','gnani@gmail.com','$2y$12$z8Fips9AUBMDdG990jWKy.jWrLht/h3WbZ5FsMMPMWRkc7Dh7rUBO',_binary 'uploads/Gimli.jpg','hey gnani here',40.00),('om','om@gmail.com','$2y$12$2bUKq0hBmjFZCAXWPqb6e.BLYc2sLJLEsTgyeSSk5MUMrTzUK76hK',_binary 'uploads/WhatsApp Image 2024-09-02 at 6.22.30 PM.jpeg','Hey im omkar !!!',125.00),('raj','raj@gmail.com','$2y$12$7K7nxi0EMRNarWyQKs8HeO/MVOnd9C9LdC0NND17J3xJvuhIxoYOa',NULL,NULL,100.00),('rajarshi','rajg@gmail.com','$2y$12$S1YRjZToydQxrDiYT7Tu/eVHmcj6PHb.6y/zlasF7xtp5r7mn/n7u',_binary 'uploads/batman.jpg','hey raj here',125.00),('ram','ram@gmail.com','$2y$12$Otr7CDDQwK5aXl4ao2hctOVscphTmZfWoO1fnCamkE4gHX5x5T/n.',NULL,NULL,100.00);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activity_logs`
--

DROP TABLE IF EXISTS `user_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `webpage` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `client_ip` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activity_logs`
--

LOCK TABLES `user_activity_logs` WRITE;
/*!40000 ALTER TABLE `user_activity_logs` DISABLE KEYS */;
INSERT INTO `user_activity_logs` VALUES (1,'om','process_login.php','2025-03-17 12:58:51','172.19.0.1'),(2,'om','home.php','2025-03-17 12:58:51','172.19.0.1'),(3,'om','view_profiles.php','2025-03-17 12:58:53','172.19.0.1'),(4,'om','view_profiles.php','2025-03-17 12:58:57','172.19.0.1'),(5,'om','view_profiles.php','2025-03-17 12:59:02','172.19.0.1'),(6,'om','logout.php','2025-03-17 12:59:56','172.19.0.1'),(7,'raj','process_login.php','2025-03-17 13:01:04','172.19.0.1'),(8,'raj','home.php','2025-03-17 13:01:04','172.19.0.1'),(9,'raj','view_profiles.php','2025-03-17 13:01:11','172.19.0.1'),(10,'raj','view_profiles.php','2025-03-17 13:01:18','172.19.0.1'),(11,'raj','view_profiles.php','2025-03-17 13:01:25','172.19.0.1'),(12,'rajarshi','process_login.php','2025-03-17 15:35:46','172.19.0.1'),(13,'rajarshi','home.php','2025-03-17 15:35:46','172.19.0.1'),(14,'rajarshi','update_profile.php','2025-03-17 15:35:50','172.19.0.1'),(15,'rajarshi','update_profile.php','2025-03-17 15:36:04','172.19.0.1'),(16,'rajarshi','home.php','2025-03-17 15:36:06','172.19.0.1'),(17,'rajarshi','view_profiles.php','2025-03-17 15:36:07','172.19.0.1'),(18,'rajarshi','view_profiles.php','2025-03-17 15:36:14','172.19.0.1'),(19,'rajarshi','transfer_money.php','2025-03-17 15:36:17','172.19.0.1'),(20,'rajarshi','transfer_history.php','2025-03-17 15:36:19','172.19.0.1'),(21,'rajarshi','transfer_money.php','2025-03-17 15:36:21','172.19.0.1'),(22,'rajarshi','transfer_money.php','2025-03-17 15:36:32','172.19.0.1'),(23,'rajarshi','transfer_money.php','2025-03-17 15:36:43','172.19.0.1'),(24,'rajarshi','transfer_history.php','2025-03-17 15:36:45','172.19.0.1'),(25,'rajarshi','logout.php','2025-03-17 15:36:59','172.19.0.1'),(26,'aviraj','process_login.php','2025-03-17 15:39:05','172.19.0.1'),(27,'aviraj','home.php','2025-03-17 15:39:05','172.19.0.1'),(28,'aviraj','update_profile.php','2025-03-17 15:39:08','172.19.0.1'),(29,'aviraj','home.php','2025-03-17 15:39:14','172.19.0.1'),(30,'aviraj','update_profile.php','2025-03-17 15:39:15','172.19.0.1'),(31,'aviraj','update_profile.php','2025-03-17 15:39:31','172.19.0.1'),(32,'aviraj','transfer_money.php','2025-03-17 15:39:34','172.19.0.1'),(33,'aviraj','transfer_money.php','2025-03-17 15:39:49','172.19.0.1'),(34,'aviraj','transfer_history.php','2025-03-17 15:39:50','172.19.0.1'),(35,'aviraj','home.php','2025-03-17 15:39:57','172.19.0.1'),(36,'aviraj','logout.php','2025-03-17 15:43:03','172.19.0.1'),(37,'gnani','process_login.php','2025-03-17 15:43:31','172.19.0.1'),(38,'gnani','home.php','2025-03-17 15:43:31','172.19.0.1'),(39,'gnani','update_profile.php','2025-03-17 15:43:36','172.19.0.1'),(40,'gnani','update_profile.php','2025-03-17 15:43:50','172.19.0.1'),(41,'gnani','home.php','2025-03-17 15:43:51','172.19.0.1'),(42,'gnani','transfer_money.php','2025-03-17 15:43:54','172.19.0.1'),(43,'gnani','transfer_money.php','2025-03-17 15:44:09','172.19.0.1'),(44,'gnani','transfer_money.php','2025-03-17 15:44:27','172.19.0.1'),(45,'gnani','transfer_history.php','2025-03-17 15:44:29','172.19.0.1'),(46,'gnani','home.php','2025-03-17 15:44:36','172.19.0.1'),(47,'gnani','logout.php','2025-03-17 15:44:41','172.19.0.1');
/*!40000 ALTER TABLE `user_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-17 15:56:04
