-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: sistem_pos
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_product`
--

DROP TABLE IF EXISTS `category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_product_category_id_foreign` (`category_id`),
  KEY `category_product_product_id_foreign` (`product_id`),
  CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_product`
--

LOCK TABLES `category_product` WRITE;
/*!40000 ALTER TABLE `category_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debt_payments`
--

DROP TABLE IF EXISTS `debt_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `debt_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `debt_id` bigint unsigned NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `dibayar_oleh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sisa_angsuran` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `debt_payments_debt_id_foreign` (`debt_id`),
  CONSTRAINT `debt_payments_debt_id_foreign` FOREIGN KEY (`debt_id`) REFERENCES `debts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debt_payments`
--

LOCK TABLES `debt_payments` WRITE;
/*!40000 ALTER TABLE `debt_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `debt_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debts`
--

DROP TABLE IF EXISTS `debts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `debts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `nama_pengutang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp` decimal(15,2) DEFAULT NULL,
  `sisa` decimal(15,2) NOT NULL,
  `status` enum('pending','lunas','batal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `debts_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `debts_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debts`
--

LOCK TABLES `debts` WRITE;
/*!40000 ALTER TABLE `debts` DISABLE KEYS */;
/*!40000 ALTER TABLE `debts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karyawans`
--

DROP TABLE IF EXISTS `karyawans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karyawans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_karyawan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `market_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `karyawans_no_karyawan_unique` (`no_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawans`
--

LOCK TABLES `karyawans` WRITE;
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markets`
--

DROP TABLE IF EXISTS `markets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `markets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kas` bigint DEFAULT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `markets_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markets`
--

LOCK TABLES `markets` WRITE;
/*!40000 ALTER TABLE `markets` DISABLE KEYS */;
INSERT INTO `markets` VALUES (1,'toko gempita','toko-gempita',NULL,'0809828323','dsjdhsjd','2024-10-16 07:53:26','2024-10-16 07:53:26');
/*!40000 ALTER TABLE `markets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_10_16_074344_create_markets_table',1),(6,'2024_10_16_103731_create_karyawans_table',1),(7,'2024_10_22_082047_create_products_table',2),(8,'2024_10_22_083306_create_transactions_table',3),(13,'2024_10_22_084728_create_supplies_table',4),(14,'2024_10_22_085254_create_order_items_table',4),(15,'2024_10_27_161657_add_modal_to_markets_table',5),(16,'2024_10_27_163439_create_categories_table',6),(17,'2024_10_27_164201_create_category_product_table',7),(18,'2024_12_11_054632_create_satuans_table',8),(19,'2024_12_23_052443_add_status_and_metode_to_transaksi_table',9),(20,'2025_02_24_093532_create_pengeluarans_table',10),(21,'2025_04_09_171403_create_debts_table',11),(22,'2025_04_09_171519_create_debt_payments_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `total_barang` int NOT NULL,
  `subtotal` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengeluarans`
--

DROP TABLE IF EXISTS `pengeluarans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengeluarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jumlah` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengeluarans`
--

LOCK TABLES `pengeluarans` WRITE;
/*!40000 ALTER TABLE `pengeluarans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengeluarans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stok` int NOT NULL,
  `harga_beli` bigint NOT NULL,
  `harga_jual` bigint NOT NULL,
  `pemasok_id` bigint unsigned DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `market_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (27,'8998888000002','default.png','Mie Sedap Ayam Bawang','pcs',10,2200,3000,NULL,'tersedia',1,'2025-07-10 08:25:19','2025-07-10 08:46:09'),(28,'8997011324102','default.png','Chitato Sapi Panggang 68g','pcs',0,7000,8500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(29,'8996001350019','default.png','Silver Queen Chunky Bar','pcs',0,10000,12000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(30,'8991001702025','default.png','Taro Net Seaweed','pcs',10,6000,7500,NULL,'tersedia',1,'2025-07-10 08:25:19','2025-07-10 23:02:28'),(31,'8998866809020','default.png','Aqua Botol 600ml','botol',0,2500,3500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(32,'8998899020011','default.png','Teh Botol Sosro 350ml','botol',0,3000,4000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(33,'8992753111115','default.png','Floridina Jeruk Pet 360ml','botol',0,3200,4500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(34,'8992988610016','default.png','Ultra Milk Cokelat 250ml','kotak',0,4800,6000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(35,'8996001301010','default.png','Susu Dancow Instant Box 400g','box',0,40000,48000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(36,'8886008100019','default.png','Rinso 900gr','6',10,3000,5000,NULL,'tersedia',1,'2025-07-10 08:25:19','2025-07-10 22:43:12'),(37,'8992772102222','default.png','Sabun Lifebuoy Merah 80gr','pcs',0,2500,3500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(38,'8992722000113','default.png','Pepsodent Pasta Gigi 190gr','tube',0,11000,14000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(39,'8999999000112','default.png','Sikat Gigi Formula','pcs',0,5000,7000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(40,'8997215211111','default.png','Bayclin Pemutih Botol 500ml','botol',0,6500,8000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(41,'8998765432100','default.png','Minyak Goreng Bimoli 1L','liter',0,17500,20000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(42,'8998888001234','default.png','Beras Ramos 5kg','karung',0,60000,68000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(43,'8996001200020','default.png','Gula Pasir Gulaku 1kg','kg',0,13000,15000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(44,'8997001200989','default.png','Garam Cap Kapal 500g','pak',0,3000,4000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(45,'8999909090001','default.png','Telur Ayam Ras 1kg','kg',0,25000,28000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(46,'8998888111111','default.png','Pop Mie Ayam Bawang','cup',0,4500,6000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(47,'8991002202234','default.png','Nextar Brownies Cokelat','pcs',10,2000,3000,NULL,'tersedia',1,'2025-07-10 08:25:19','2025-07-10 23:12:23'),(48,'8998009002222','default.png','Beng-Beng','pcs',0,1500,2000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(49,'8991102000001','default.png','Roma Malkist Cokelat','pak',0,3500,5000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(50,'8992201101100','default.png','Qtela Singkong Balado','pcs',0,6000,7500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(51,'8992727123444','default.png','Pilus Garuda Pedas','pcs',0,1800,2500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(52,'8992703123456','default.png','Fruit Tea Apel 350ml','botol',0,3200,4500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(53,'8992772154321','default.png','Good Day Cappuccino','sachet',0,1800,2500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(54,'8998888999999','default.png','Mizone Lychee Lemon','botol',0,4000,5000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(55,'8992772200000','default.png','Nu Green Tea 330ml','botol',0,3000,4000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(56,'8992999222222','default.png','Shampoo Lifebuoy 170ml','botol',0,14500,18000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(57,'8991111100003','default.png','Dettol Sabun Cair 250ml','botol',20,21000,25000,NULL,'tersedia',1,'2025-07-10 08:25:19','2025-07-10 23:02:28'),(58,'8999888777770','default.png','Tissue Paseo Travel Pack','pak',0,4500,6000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(59,'8997744222211','default.png','Hand Sanitizer 100ml','botol',0,8000,10000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(60,'8997700112233','default.png','Sarden ABC 425g','kaleng',0,15000,18000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(61,'8997710000011','default.png','Kecap ABC Manis 135ml','botol',0,5000,7000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(62,'8999111001234','default.png','Sambal Indofood Extra Pedas','botol',0,7500,9000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(63,'8998223000123','default.png','Telur Rebus Kupas 2pcs','pak',0,5000,6000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(64,'8999911111111','default.png','Pulpen Standard AE7','pcs',0,2000,3000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(65,'8999922222222','default.png','Buku Tulis Sidu 38 Lbr','buku',0,3000,4000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(66,'8999933333333','default.png','Roti Sobek Cokelat','pak',0,5500,7000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(67,'8999944444444','default.png','Pasta Gigi Pepsodent Sachet','sachet',0,1500,2000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(68,'8999955555555','default.png','Minyak Kayu Putih Caplang 60ml','botol',0,10000,12000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(69,'8998888888881','default.png','Oreo Vanilla 137g','pak',0,7000,9000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(70,'8998888888882','default.png','Tic Tac Permen Mint','pcs',0,3500,5000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(71,'8998888888883','default.png','Astor Cokelat 150g','pak',0,9500,12000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(72,'8998888888884','default.png','Nabati Wafer Keju','pcs',0,2000,3000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(73,'8998888888885','default.png','Permen Kopiko','pak',0,1500,2000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(74,'8998888888886','default.png','Choki-Choki 3pcs','pak',0,1800,2500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(75,'8998888888891','default.png','Le Minerale 600ml','botol',0,2500,3500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(76,'8998888888892','default.png','S-tee Jasmine Tea','botol',0,3000,4000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(77,'8998888888893','default.png','Pocari Sweat Botol 500ml','botol',0,7500,9000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(78,'8998888888894','default.png','You C1000 Lemon','botol',0,6500,8000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(79,'8998888888895','default.png','Sabun Mandi Lux 80gr','pcs',0,2500,3500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(80,'8998888888896','default.png','Sampo Clear Sachet','sachet',0,1500,2000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(81,'8998888888897','default.png','Sabun Cuci Muka Ponds','tube',0,11000,14000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(82,'8998888888898','default.png','Tissue Nice Box','box',0,9500,12000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(83,'8998888888899','default.png','Kornet Pronas 198g','kaleng',0,15000,18000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(84,'8998888888900','default.png','Susu Kental Manis Frisian Flag','sachet',0,10000,12000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(85,'8998888888901','default.png','Bumbu Indofood Rendang','sachet',0,2200,3000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(86,'8998888888902','default.png','Mie Telur Cap 3 Ayam 200g','pak',0,3500,4500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(87,'8998888888903','default.png','Penggaris 30cm','pcs',0,1500,2500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(88,'8998888888904','default.png','Pensil 2B Faber Castell','pcs',0,2000,3000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(89,'8998888888905','default.png','Penghapus Putih Joyko','pcs',0,1000,1500,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19'),(90,'8998888888906','default.png','Stipo Kecil','pcs',0,3500,5000,NULL,'habis',1,'2025-07-10 08:25:19','2025-07-10 08:25:19');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satuans`
--

DROP TABLE IF EXISTS `satuans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satuans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satuans`
--

LOCK TABLES `satuans` WRITE;
/*!40000 ALTER TABLE `satuans` DISABLE KEYS */;
INSERT INTO `satuans` VALUES (6,'Pcs','2025-04-14 04:56:51','2025-04-14 04:56:51');
/*!40000 ALTER TABLE `satuans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplies`
--

DROP TABLE IF EXISTS `supplies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `harga_beli` bigint NOT NULL,
  `jumlah` int NOT NULL,
  `pemasok` bigint unsigned DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplies`
--

LOCK TABLES `supplies` WRITE;
/*!40000 ALTER TABLE `supplies` DISABLE KEYS */;
INSERT INTO `supplies` VALUES (29,'8991002101234',26,2000,5,NULL,4,'2025-07-10 08:30:19','2025-07-10 08:33:36'),(30,'8998888000002',27,2200,10,NULL,4,'2025-07-10 08:46:09','2025-07-10 08:46:09'),(31,'8886008100019',36,15000,0,NULL,4,'2025-07-10 22:41:04','2025-07-10 22:43:12'),(32,'8886008100019',36,2000,10,NULL,4,'2025-07-10 22:41:34','2025-07-10 22:43:12'),(33,'8991001702025',30,6000,10,NULL,4,'2025-07-10 23:02:28','2025-07-10 23:02:28'),(34,'8991111100003',57,21000,20,NULL,4,'2025-07-10 23:02:28','2025-07-10 23:02:28'),(35,'8991002202234',47,2000,10,NULL,4,'2025-07-10 23:12:23','2025-07-10 23:12:23');
/*!40000 ALTER TABLE `supplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` bigint NOT NULL,
  `diskon` int NOT NULL,
  `total` bigint DEFAULT NULL,
  `bayar` bigint DEFAULT NULL,
  `kembali` bigint NOT NULL,
  `market_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','completed','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `metode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_karyawan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `market_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_no_karyawan_unique` (`no_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Admin','admin@gmail.com','102210023','foto_1744561498_67fbe55a4aa64.jpg',NULL,'$2y$12$uhAQBaTf/4liqFGw30b6mettA941iXyH0Aj5swiHWilDPSRSIeIHW','admin',1,NULL,'2024-10-22 05:18:58','2025-04-14 05:35:27'),(9,'coba','coba@yahoo.com','124578','default.png',NULL,'$2y$12$KiVyWSOvU2MIe/h.IjPc7uGJKVb7Spjf7OtYB6dp/l1KYo5tWA8ie','admin',1,NULL,'2025-04-13 17:16:19','2025-04-13 17:16:33'),(10,'coba terakhir','dlollin@gmail.com','102210089','default.png',NULL,'$2y$12$0UrXns1AdNHtH51ZalUdKO9JOiWXdJGiLq0QXinjlhvtWZC9FRaze','kasir',1,NULL,'2025-04-14 04:54:13','2025-04-14 04:54:47');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sistem_pos'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-11 14:02:50
