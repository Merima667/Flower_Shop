-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: flower_shop
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Merima','Balihodzic','merima.balihodzic@gmail.com','12345678'),(2,'Amina Updated','Melunovic','amina.new@gmail.com','$2y$10$p0zJZeirO/T2RO3favWVNuxngT/v/bs.ln37EPN8.13RVn37EJ95u'),(5,'Amina','Kovac','amina.kovac@gmail.com','$2y$10$.FXmhdpEh3DNnWm1quLCGee7j43wiuo5FS46I2vKCDtWH9Ff9l5a.');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Roses','A timeless symbol of love and beauty, our roses come in vibrant colors and elegant arrangements, perfect for any occasion.'),(2,'tulips','Brighten your home with the timeless beauty of tulips. Known for their vibrant colors and elegant shape, tulips are perfect for any occasion or as a cheerful addition to your garden.'),(3,'roses','Classic and romantic roses in various colors. Perfect for expressing love, gratitude, or sympathy on any special occasion.'),(4,'sunflowers','Bright and cheerful sunflowers that bring sunshine into any room. Symbol of happiness and positivity.');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Medina','Alic','medina.alic@gmail.com','87654321','Butmirska cesta 18d, Ilidza'),(2,'Nejla','Hasanovic','nejla.hasanovic@gmail.com','$2y$10$g6DZ..unY8S3e3bzyOxVtefvRHEB4iIDTnLj47VALzCMTyGNAeTvm','Hrasnicka cesta'),(3,'Lejla','Bajramovic','lejla.bajramovic@gmail.com','$2y$10$s2uVps1hVWwKWs/L.eQSo.cvY.7i3hPsf4WzLBSkgr6Xl/6dL0CkG','Zmaja od Bosne 12');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderdetails` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `quantity` int NOT NULL,
  `product_id` int unsigned NOT NULL,
  `order_id` int unsigned NOT NULL,
  `admin_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orderdetails_unique` (`product_id`),
  UNIQUE KEY `orderdetails_unique_1` (`order_id`),
  KEY `orderdetails_admins_FK` (`admin_id`),
  CONSTRAINT `orderdetails_admins_FK` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  CONSTRAINT `orderdetails_orders_FK` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orderdetails_products_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdetails`
--

LOCK TABLES `orderdetails` WRITE;
/*!40000 ALTER TABLE `orderdetails` DISABLE KEYS */;
INSERT INTO `orderdetails` VALUES (1,'A timeless symbol of love and beauty, our roses come in vibrant colors and elegant arrangements, perfect for any occasion.',3,1,1,1),(2,'Red Tulip Bouquet',1,2,2,2),(9,'Red Roses Premium Bouquet - Gift Wrapped',1,7,3,5);
/*!40000 ALTER TABLE `orderdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL,
  `status` enum('pending','shipped','delivered','cancelled') NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `customer_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customers_FK` (`customer_id`),
  CONSTRAINT `orders_customers_FK` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2025-10-20','pending',55.20,1),(2,'2025-10-24','shipped',20.90,2),(3,'2025-10-31','pending',75.49,2),(4,'2025-10-31','pending',75.49,2),(5,'2025-10-31','pending',75.49,2),(6,'2025-10-31','pending',75.49,2);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int DEFAULT NULL,
  `image_url` text NOT NULL,
  `category_id` int unsigned NOT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_admins_FK` (`admin_id`),
  KEY `products_categories_FK` (`category_id`),
  CONSTRAINT `products_admins_FK` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  CONSTRAINT `products_categories_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('Rose','A timeless symbol of love and beauty, our roses come in vibrant colors and elegant arrangements, perfect for any occasion.',20.00,20,'C:\\xampp\\htdocs\\Flower_Shop\\frontend\\assets\\FB69VCP_LOL_preset_proflowers-mx-tile-wide-sv-new.webp',1,1,1),('Tulips','Brighten your home with the timeless beauty of tulips. Known for their vibrant colors and elegant shape, tulips are perfect for any occasion or as a cheerful addition to your garden.',42.99,10,'C:\\xampp\\htdocs\\Flower_Shop\\frontend\\assets\\FB69VCP_LOL_preset_proflowers-mx-tile-wide-sv-new.webp',2,2,2),('Red Roses Bouquet','Elegant bouquet of 12 premium red roses with greenery',45.99,15,'red_roses.webp',3,7,5),('Red Roses Bouquet','Elegant bouquet of 12 premium red roses with greenery',45.99,15,'red_roses.webp',3,10,5);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `review_description` text NOT NULL,
  `customer_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'Medina','Beautiful',1,1),(3,'Hana','The most beautiful bouquet I have ever seen',2,2);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'flower_shop'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-31 16:20:34
