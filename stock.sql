-- ============================================================
-- Yero Printing ERP - merged database setup
-- ============================================================
-- This single file is the complete, current stock database dump.
-- It merges the former bank_integration.sql (banks table) and
-- sms_integration.sql (sms_log + company SMS columns) PLUS every
-- later schema change already applied to the live database
-- (Telebirr payments, printer/paper settings, property, etc.).
--
-- How to set up a fresh database:
--   mysql -u root < stock.sql
-- (drops and recreates the "stock" database, then imports all rows)
-- ============================================================

-- MySQL dump 10.13  Distrib 8.2.0, for Win64 (x86_64)
--
-- Host: localhost    Database: stock
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Current Database: `stock`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `stock` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `stock`;

--
-- Table structure for table `attribute_value`
--

DROP TABLE IF EXISTS `attribute_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `attribute_parent_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_value`
--

LOCK TABLES `attribute_value` WRITE;
/*!40000 ALTER TABLE `attribute_value` DISABLE KEYS */;
INSERT INTO `attribute_value` VALUES (5,'Blue',2),(6,'White',2),(7,'M',3),(8,'L',3),(9,'Green',2),(10,'Black',2),(12,'Grey',2),(13,'S',3),(14,'50',4),(15,'mnbn',5),(16,'Kennaa',6),(17,'Ramaddii',6),(18,'Bittaa',6),(19,'Dhaalma',6),(20,'Dhuunfa',7),(21,'Dhaabbata/ Waldaa',7),(22,'Kan Motummaa',7),(23,'Miti Motummaa',7),(24,'Kan ummataa/Araddaa',7),(25,'1ffaa',8),(26,'2ffaa',8),(27,'3ffaa',8),(28,'4ffaa',8),(29,'5ffaa',8),(30,'6ffaa',8),(31,'7ffaa',8);
/*!40000 ALTER TABLE `attribute_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributes`
--

LOCK TABLES `attributes` WRITE;
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_type` varchar(100) DEFAULT '',
  `category` varchar(50) NOT NULL DEFAULT 'bank',
  `is_default` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'Commercial bank of ethiopia','Yeroo Printing','1000067543','Current','bank',0,1,2026),(2,'telebirr','Yeroo','0920899329','current','telebirr',0,1,2026);
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (9,'crystal',1),(10,'trodat',1),(11,'baanar',1),(12,'stiker',1),(13,'photo',1);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (11,'Baanar',1),(12,'Stiikaar',1),(13,'photo',1),(19,'Certificate',1),(20,'Badge',1),(21,'Id card',1),(22,'Bussiness Card',1),(23,'Tshirt',1),(24,'Stampp',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `service_charge_value` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL,
  `website` varchar(100) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `tiktok` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `telegram` varchar(100) NOT NULL,
  `sms_enabled` int DEFAULT '0',
  `sms_token` varchar(255) DEFAULT '',
  `sms_shortcode` varchar(255) DEFAULT '',
  `printer_type` varchar(100) DEFAULT 'thermal',
  `paper_size` varchar(100) DEFAULT '80mm',
  `paper_width` int DEFAULT '80',
  `paper_height` int DEFAULT '297',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'Shareholders Management','1','2','Magaalaa Ciroo','(123) 456-7890','Ethiopia','Sample message<br>','ETB','https://www.yeroo.com','https://facebook.com/yeroo','https://tiktok.com/yeroo5564','https://t.me/yeroo',0,'','','thermal','80mm',80,297);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `epossition` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `oname` varchar(100) NOT NULL,
  `oaddress` varchar(100) NOT NULL,
  `phone` varchar(111) NOT NULL,
  `ctype` int NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'mohammed','officer','obu','Ciroo','2147483647',1,1),(2,'Nigaatu','Ittii Gaafatama','Mana Suuraa feenet','Micheta','920299325',1,0);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `education_dep` varchar(150) NOT NULL,
  `id_number` varchar(55) NOT NULL,
  `emp_gender` varchar(100) NOT NULL,
  `job_dep` varchar(111) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  `phone` int NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'Mahammad Ahmad','surveying','345id','male','Mahandiis I','diigrii',911910570,'ciroo',0);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Administrator','a:56:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:11:\"createStore\";i:17;s:11:\"updateStore\";i:18;s:9:\"viewStore\";i:19;s:11:\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:11:\"viewReports\";i:33;s:13:\"updateCompany\";i:34;s:11:\"viewProfile\";i:35;s:13:\"updateSetting\";i:36;s:17:\"createShareholder\";i:37;s:17:\"updateShareholder\";i:38;s:15:\"viewShareholder\";i:39;s:17:\"deleteShareholder\";i:40;s:18:\"createFamilyMember\";i:41;s:18:\"updateFamilyMember\";i:42;s:16:\"viewFamilyMember\";i:43;s:18:\"deleteFamilyMember\";i:44;s:17:\"createTransaction\";i:45;s:17:\"updateTransaction\";i:46;s:15:\"viewTransaction\";i:47;s:17:\"deleteTransaction\";i:48;s:16:\"createShareIssue\";i:49;s:16:\"updateShareIssue\";i:50;s:14:\"viewShareIssue\";i:51;s:16:\"deleteShareIssue\";i:52;s:14:\"createDividend\";i:53;s:14:\"updateDividend\";i:54;s:12:\"viewDividend\";i:55;s:14:\"deleteDividend\";}'),(4,'Owners','a:56:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:11:\"createStore\";i:17;s:11:\"updateStore\";i:18;s:9:\"viewStore\";i:19;s:11:\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:11:\"viewReports\";i:33;s:13:\"updateCompany\";i:34;s:11:\"viewProfile\";i:35;s:13:\"updateSetting\";i:36;s:17:\"createShareholder\";i:37;s:17:\"updateShareholder\";i:38;s:15:\"viewShareholder\";i:39;s:17:\"deleteShareholder\";i:40;s:18:\"createFamilyMember\";i:41;s:18:\"updateFamilyMember\";i:42;s:16:\"viewFamilyMember\";i:43;s:18:\"deleteFamilyMember\";i:44;s:17:\"createTransaction\";i:45;s:17:\"updateTransaction\";i:46;s:15:\"viewTransaction\";i:47;s:17:\"deleteTransaction\";i:48;s:16:\"createShareIssue\";i:49;s:16:\"updateShareIssue\";i:50;s:14:\"viewShareIssue\";i:51;s:16:\"deleteShareIssue\";i:52;s:14:\"createDividend\";i:53;s:14:\"updateDividend\";i:54;s:12:\"viewDividend\";i:55;s:14:\"deleteDividend\";}'),(5,'cashier','a:8:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createOrder\";i:5;s:11:\"updateOrder\";i:6;s:9:\"viewOrder\";i:7;s:11:\"deleteOrder\";}');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `customer_types` int NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `gross_amount` varchar(255) NOT NULL,
  `service_charge_rate` varchar(255) NOT NULL,
  `service_charge` varchar(255) NOT NULL,
  `vat_charge_rate` varchar(255) NOT NULL,
  `vat_charge` varchar(255) NOT NULL,
  `net_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `paid_status` int NOT NULL,
  `process_status` int NOT NULL,
  `user_id` int NOT NULL,
  `size_width` varchar(110) NOT NULL,
  `size_height` varchar(50) NOT NULL,
  `kaaree` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,'BILPR-CD4F',2,'1','','','1690740815','500.00','1','5.00','2','10.00','515.00','',1,1,1,'','',''),(6,'BILPR-E6D7',2,'2','','','1690741415','1200.00','1','12.00','2','24.00','1236.00','',2,0,1,'','',''),(12,'BILPR-F22C',2,'2','','','1690827203','2450.00','1','24.50','2','49.00','2523.50','',0,1,1,'','',''),(13,'BILPR-8EFF',2,'1','','','1716135940','500.00','1','5.00','2','10.00','515.00','',2,0,1,'','',''),(14,'BILPR-439A',2,'2','','','1716136533','500.00','1','5.00','2','10.00','515.00','0',2,0,1,'','',''),(16,'BILPR-A151',0,'gj','09','09','1716143236','6240.00','1','62.40','2','124.80','6427.20','',2,0,1,'','',''),(17,'BILPR-8DB2',0,'yg','fgff','66','1716145153','24960.00','1','249.60','2','499.20','25708.80','',2,0,1,'','',''),(18,'BILPR-DAB4',0,'554','dd','665','1716145484','6400.00','1','64.00','2','128.00','6592.00','',2,0,1,'','',''),(19,'BILPR-3573',0,'ffd','dd','5655','1716145598','27200.00','1','272.00','2','544.00','28016.00','',1,0,1,'','',''),(20,'yeroo-505D',0,'ffr','44','903','1716146811','10160.00','1','101.60','2','203.20','9464.80','1000',2,0,1,'','',''),(21,'yeroo-AE2D',2,'2','','','1716149135','14240.00','1','142.40','2','284.80','14667.20','',2,0,1,'','','');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_item`
--

DROP TABLE IF EXISTS `orders_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `wdth` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `hgt` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `kaaree` varchar(50) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_item`
--

LOCK TABLES `orders_item` WRITE;
/*!40000 ALTER TABLE `orders_item` DISABLE KEYS */;
INSERT INTO `orders_item` VALUES (23,5,3,'','','','1','500','500.00'),(28,6,3,'','','','1','500','500.00'),(29,6,2,'','','','5','350','350.00'),(30,6,2,'','','','2','350','350.00'),(39,12,2,'','','','1','350','350.00'),(40,12,2,'','','','6','350','2100.00'),(42,13,3,'','','','1','500','500.00'),(43,14,3,'','','','1','500','500.00'),(45,16,4,'','','','1','800','6240.000000000001'),(46,17,4,'','','','1','800','24960.000000000004'),(47,18,4,'','','','1','800','6400'),(48,19,4,'5','6.8','34','1','800','27200'),(50,20,4,'','','','1','800','9600'),(51,20,5,'','','','2','560','560.00'),(52,21,4,'5','3','15','1','800','12000'),(53,21,5,'','','','4','560','2240');
/*!40000 ALTER TABLE `orders_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_types` int NOT NULL,
  `customer_name` varchar(110) NOT NULL,
  `payment_types` int NOT NULL,
  `total_amount` varchar(110) NOT NULL,
  `order_no` varchar(55) NOT NULL,
  `datetime` int NOT NULL,
  `payment_status` int NOT NULL,
  `tt_number` varchar(100) NOT NULL,
  `paid_amount` varchar(55) NOT NULL,
  `due_amount` varchar(11) NOT NULL,
  `bank_account_id` int DEFAULT NULL,
  `bill_no` varchar(11) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` (`id`,`customer_types`,`customer_name`,`payment_types`,`total_amount`,`order_no`,`datetime`,`payment_status`,`tt_number`,`paid_amount`,`due_amount`,`bank_account_id`,`bill_no`,`status`) VALUES (1,0,'0',2,'3042','10',1690823231,2,'','1000','0',NULL,'0',0),(6,0,'0',0,'1388.00','1',1690920666,1,'ttygb65hg','1131','0',NULL,'BILPR-5367',0),(3,0,'0',2,'1388.00','11',1690823679,2,'tt65457gf','257','1131.00',NULL,'0',0),(4,2,'2',1,'2523.50','12',1690827204,2,'ttdggr5665','1000','',NULL,'BILPR-F22C',0),(7,2,'1',2,'515.00','5',1690922517,1,'45432ffgd','515.00','0',NULL,'BILPR-CD4F',0),(8,0,'Bulcha Abdi',0,'3041.50','10',1691100982,1,'cash','2042','0',NULL,'BILPR-4698',0),(9,2,'1',0,'515.00','13',1716135940,2,'','','515.00',NULL,'BILPR-8EFF',0),(10,2,'2',0,'515.00','14',1716136533,2,'','400','115.00',NULL,'BILPR-439A',0),(11,0,'',0,'824.00','15',1716139035,2,'','','824.00',NULL,'BILPR-3497',0),(12,0,'gj',0,'6427.20','16',1716143236,2,'','','6427.20',NULL,'BILPR-A151',0),(13,0,'yg',0,'25708.80','17',1716145153,2,'','','25708.80',NULL,'BILPR-8DB2',0),(14,0,'554',0,'6592.00','18',1716145484,2,'','','6592.00',NULL,'BILPR-DAB4',0),(15,0,'ffd',0,'28016.00','19',1716145598,2,'','1000','28016.00',NULL,'BILPR-3573',0),(16,0,'ffd',0,'28016.00','19',1716146113,1,'','1000','0',NULL,'BILPR-3573',0),(17,0,'ffr',0,'8888.00','20',1716146811,2,'','0','8888.00',NULL,'yeroo-505D',0),(18,0,'ffr',0,'8888.00','20',1716146874,1,'','8888','0',NULL,'yeroo-505D',0),(19,2,'2',0,'14667.20','21',1716149135,0,'','0','14667.20',NULL,'yeroo-AE2D',0);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process`
--

DROP TABLE IF EXISTS `process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_no` int NOT NULL,
  `process_status` int NOT NULL,
  `processed_date` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `bill_no` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process`
--

LOCK TABLES `process` WRITE;
/*!40000 ALTER TABLE `process` DISABLE KEYS */;
INSERT INTO `process` VALUES (9,20,0,'1716149135',0,'yeroo-505D');
/*!40000 ALTER TABLE `process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `attribute_value_id` text,
  `brand_id` text NOT NULL,
  `category_id` text NOT NULL,
  `store_id` int NOT NULL,
  `availability` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (4,'Baanar','Kaaree','800','9992','<p>You did not select a file to upload.</p>','<p>tiishartii</p>','null','[\"11\"]','[\"11\"]',8,1),(5,'saa','aa','560','883','<p>You did not select a file to upload.</p>','<p>aaa</p>','null','[\"9\"]','[\"11\"]',8,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `area_land` int NOT NULL,
  `area_house` int NOT NULL,
  `b_south` varchar(100) NOT NULL,
  `b_north` varchar(111) NOT NULL,
  `b_east` varchar(100) NOT NULL,
  `b_west` varchar(100) NOT NULL,
  `t_payment` int NOT NULL,
  `p_license` int NOT NULL,
  `date_get` int NOT NULL,
  `status_get` int NOT NULL,
  `customer_types` int NOT NULL,
  `property_type` int NOT NULL,
  `property_rank` int NOT NULL,
  `address_block` int NOT NULL,
  `address_kebele` int NOT NULL,
  `address_town` varchar(100) NOT NULL,
  `tax` int NOT NULL,
  `customer_kebele_id` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `attribute_value_id` varchar(110) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (1,'bbb',23,33,'322a','asd3','2ws','sew3',2,2,2023,0,0,9,7,0,6,'',0,'',0,'[\"16\",\"24\",\"29\"]'),(2,'Bulcha Abdi',500,106,'Ahmad','Yuyyaa','Adaam','Mahammad',2,1,1691452800,0,0,6,7,0,7,'',0,'',0,'[\"18\",\"20\",\"25\"]');
/*!40000 ALTER TABLE `property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_certificate`
--

DROP TABLE IF EXISTS `property_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_certificate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `certificate_number` int NOT NULL,
  `certificate_property_number` varchar(100) NOT NULL,
  `gps` varchar(100) NOT NULL,
  `borders` varchar(111) NOT NULL,
  `date_given` int NOT NULL,
  `date_seen` int NOT NULL,
  `year_of_construction` int NOT NULL,
  `year_of_payment` int NOT NULL,
  `employe_given` int NOT NULL,
  `employe_approve` int NOT NULL,
  `property_id` int NOT NULL,
  `payment_number` varchar(50) NOT NULL,
  `receipt_number_payment` int NOT NULL,
  `receipt_bank` varchar(50) NOT NULL,
  `current_date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_certificate`
--

LOCK TABLES `property_certificate` WRITE;
/*!40000 ALTER TABLE `property_certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_log`
--

DROP TABLE IF EXISTS `sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sms_type` varchar(50) NOT NULL,
  `status` int DEFAULT '0',
  `api_response` text,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_log`
--

LOCK TABLES `sms_log` WRITE;
/*!40000 ALTER TABLE `sms_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (8,'Mana Maxxansaa',1),(9,'Mana phooto',1);
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,1,1),(9,8,5);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$ZrBk2zWOLhPAaOhncDBJv.pKAfhFYywahFQXY4NXDmhOcaRtLdAfS','admin@admin.com','admin','a','12345678910',1),(8,'cashier','$2y$10$wxEPtywtRwKqNcAmFHiLhOwoItKkMWaLhJgRyzmSaPm0RelqEIZxa','cashier@gmail.com','asdasas','dagahajaj','09090909009',2);
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

-- Dump completed on 2026-09-11 20:29:17
