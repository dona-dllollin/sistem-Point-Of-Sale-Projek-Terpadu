-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 04:57 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `gambar`, `name`, `created_at`, `updated_at`) VALUES
(2, 'example-foto.jpg', 'makanan', NULL, NULL),
(3, 'sample_img.jpg', 'Sembako', NULL, NULL),
(4, '1734188853.png', 'Kopi', '2024-12-14 00:41:41', '2024-12-14 08:07:33'),
(5, 'default.jpg', 'teteh', '2024-12-14 00:44:46', '2024-12-14 08:06:57'),
(7, 'default.jpg', 'Mie Instan', '2024-12-21 04:56:50', '2024-12-21 04:56:50'),
(8, '1734783786.png', 'Bakso', '2024-12-21 05:15:24', '2024-12-21 05:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `category_id`, `product_id`, `created_at`, `updated_at`) VALUES
(6, 3, 7, NULL, NULL),
(7, 2, 7, NULL, NULL),
(12, 3, 9, NULL, NULL),
(13, 2, 9, NULL, NULL),
(15, 3, 10, NULL, NULL),
(21, 3, 12, NULL, NULL),
(26, 2, 15, NULL, NULL),
(27, 3, 16, NULL, NULL),
(28, 2, 10, NULL, NULL),
(31, 3, 17, NULL, NULL),
(33, 4, 17, NULL, NULL),
(34, 2, 19, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id`, `no_karyawan`, `nama`, `no_hp`, `email`, `alamat`, `tanggal_masuk`, `market_id`, `created_at`, `updated_at`) VALUES
(1, '102210023', 'dona', '08987787652', 'dona@gmail.com', 'hsajhsa', '2024-10-02', 1, NULL, NULL),
(2, '12345678', 'dlollin', '090920129182', 'dlollin@gmail.com', 'wqwqwqw', '2024-11-05', 2, '2024-11-05 04:19:15', '2024-11-05 04:19:15'),
(4, '19282', 'dlollin', '089878', 'mencoba@gmail.com', 'dnoadoadoacc', '2024-12-09', 2, '2024-12-09 07:59:48', '2024-12-21 02:14:20'),
(5, '089878', 'kembali', '08976765', 'kembali@gmail.com', 'ggdwwgugwuee', '2024-12-10', 3, '2024-12-10 03:09:34', '2024-12-20 21:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kas` bigint(255) DEFAULT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `nama_toko`, `slug`, `kas`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'toko gempita', 'toko-gempita', NULL, '0809828323', 'dsjdhsjd', '2024-10-16 07:53:26', '2024-10-16 07:53:26'),
(2, 'toko budiono', 'toko-budiono', 1000000, '08987766551', 'qiuwqw', NULL, NULL),
(3, 'toko enam', 'toko-tambah-berhasil', 1000000, '08987767656', 'hshahsa', '2024-12-20 09:10:53', '2024-12-20 10:10:26'),
(4, 'toko budino', 'toko-budino', 1000000, '0928192', 'bsajsbas', '2024-12-20 09:11:10', '2024-12-21 02:24:53'),
(8, 'bisa', 'bisa', 1000, '08088938', 'dddsd', '2024-12-21 02:27:18', '2024-12-21 02:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_16_074344_create_markets_table', 1),
(6, '2024_10_16_103731_create_karyawans_table', 1),
(7, '2024_10_22_082047_create_products_table', 2),
(8, '2024_10_22_083306_create_transactions_table', 3),
(13, '2024_10_22_084728_create_supplies_table', 4),
(14, '2024_10_22_085254_create_order_items_table', 4),
(15, '2024_10_27_161657_add_modal_to_markets_table', 5),
(16, '2024_10_27_163439_create_categories_table', 6),
(17, '2024_10_27_164201_create_category_product_table', 7),
(18, '2024_12_11_054632_create_satuans_table', 8),
(19, '2024_12_23_052443_add_status_and_metode_to_transaksi_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `total_barang` int(11) NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `transaction_id`, `product_id`, `total_barang`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 15, 10, 5, 15000, '2024-12-03 02:31:41', '2024-12-03 02:31:41'),
(2, 16, 10, 5, 15000, '2024-12-03 02:33:46', '2024-12-03 02:33:46'),
(3, 17, 10, 4, 12000, '2024-12-03 02:34:47', '2024-12-03 02:34:47'),
(4, 18, 11, 1, 3000, '2024-12-03 02:37:57', '2024-12-03 02:37:57'),
(5, 19, 9, 1, 4000, '2024-12-03 02:38:50', '2024-12-03 02:38:50'),
(6, 20, 10, 3, 9000, '2024-12-03 04:32:55', '2024-12-03 04:32:55'),
(7, 21, 8, 1, 4000, '2024-12-03 04:34:15', '2024-12-03 04:34:15'),
(8, 21, 10, 1, 3000, '2024-12-03 04:34:15', '2024-12-03 04:34:15'),
(9, 21, 14, 1, 10000, '2024-12-03 04:34:15', '2024-12-03 04:34:15'),
(10, 22, 16, 2, 22000, '2024-12-03 05:37:10', '2024-12-03 05:37:10'),
(11, 23, 13, 3, 6000, '2024-12-05 01:01:08', '2024-12-05 01:01:08'),
(12, 24, 14, 3, 30000, '2024-12-05 01:05:36', '2024-12-05 01:05:36'),
(13, 25, 8, 2, 8000, '2024-12-05 01:37:07', '2024-12-05 01:37:07'),
(14, 25, 10, 2, 6000, '2024-12-05 01:37:07', '2024-12-05 01:37:07'),
(15, 25, 14, 2, 20000, '2024-12-05 01:37:07', '2024-12-05 01:37:07'),
(16, 26, 10, 3, 9000, '2024-12-05 01:41:00', '2024-12-05 01:41:00'),
(17, 27, 16, 4, 44000, '2024-12-05 01:43:04', '2024-12-05 01:43:04'),
(18, 28, 10, 8, 24000, '2024-12-05 01:43:56', '2024-12-05 01:43:56'),
(19, 29, 14, 8, 80000, '2024-12-05 01:45:38', '2024-12-05 01:45:38'),
(20, 30, 12, 1, 2000, '2024-12-20 11:06:38', '2024-12-20 11:06:38'),
(21, 30, 15, 1, 6000, '2024-12-20 11:06:38', '2024-12-20 11:06:38'),
(22, 30, 17, 1, 2000, '2024-12-20 11:06:38', '2024-12-20 11:06:38'),
(23, 31, 15, 3, 18000, '2024-12-23 00:21:45', '2024-12-23 00:21:45'),
(24, 31, 17, 2, 4000, '2024-12-23 00:21:45', '2024-12-23 00:21:45'),
(25, 32, 17, 3, 6000, '2024-12-23 00:32:40', '2024-12-23 00:32:40'),
(26, 33, 17, 2, 4000, '2024-12-23 00:35:05', '2024-12-23 00:35:05'),
(27, 34, 17, 2, 4000, '2024-12-23 00:37:03', '2024-12-23 00:37:03'),
(28, 34, 15, 1, 6000, '2024-12-23 00:37:03', '2024-12-23 00:37:03'),
(29, 35, 17, 2, 4000, '2024-12-23 00:39:21', '2024-12-23 00:39:21'),
(30, 36, 15, 2, 12000, '2024-12-23 00:54:29', '2024-12-23 00:54:29'),
(31, 37, 15, 3, 18000, '2024-12-23 00:59:49', '2024-12-23 00:59:49'),
(32, 38, 15, 2, 12000, '2024-12-23 01:02:46', '2024-12-23 01:02:46'),
(33, 39, 15, 2, 12000, '2024-12-23 01:04:32', '2024-12-23 01:04:32'),
(34, 40, 18, 2, 3000, '2024-12-23 01:07:27', '2024-12-23 01:07:27'),
(35, 41, 10, 2, 6000, '2024-12-23 01:08:39', '2024-12-23 01:08:39'),
(36, 42, 18, 2, 3000, '2024-12-23 01:10:05', '2024-12-23 01:10:05'),
(37, 43, 13, 2, 4000, '2024-12-23 01:11:58', '2024-12-23 01:11:58'),
(38, 44, 16, 2, 22000, '2024-12-23 01:13:02', '2024-12-23 01:13:02'),
(39, 45, 17, 2, 4000, '2024-12-23 01:24:57', '2024-12-23 01:24:57'),
(40, 46, 15, 2, 12000, '2024-12-23 01:26:36', '2024-12-23 01:26:36'),
(41, 47, 17, 2, 4000, '2024-12-23 01:34:55', '2024-12-23 01:34:55'),
(42, 48, 15, 3, 18000, '2024-12-23 01:39:38', '2024-12-23 01:39:38'),
(43, 49, 15, 2, 12000, '2024-12-23 01:41:05', '2024-12-23 01:41:05'),
(44, 50, 17, 3, 6000, '2024-12-23 01:51:15', '2024-12-23 01:51:15'),
(45, 51, 17, 2, 4000, '2024-12-23 02:17:19', '2024-12-23 02:17:19'),
(46, 52, 15, 3, 18000, '2024-12-23 02:22:56', '2024-12-23 02:22:56'),
(47, 53, 17, 2, 4000, '2024-12-23 02:27:28', '2024-12-23 02:27:28'),
(48, 54, 17, 2, 4000, '2024-12-23 02:27:37', '2024-12-23 02:27:37'),
(49, 55, 17, 2, 4000, '2024-12-23 02:28:55', '2024-12-23 02:28:55'),
(50, 56, 17, 2, 4000, '2024-12-23 02:29:53', '2024-12-23 02:29:53'),
(51, 57, 17, 2, 4000, '2024-12-23 02:38:28', '2024-12-23 02:38:28'),
(52, 58, 13, 3, 6000, '2024-12-23 04:46:22', '2024-12-23 04:46:22'),
(53, 59, 10, 3, 9000, '2024-12-23 04:50:11', '2024-12-23 04:50:11'),
(54, 60, 10, 3, 9000, '2024-12-23 05:01:47', '2024-12-23 05:01:47'),
(55, 61, 10, 2, 6000, '2024-12-23 05:04:46', '2024-12-23 05:04:46'),
(56, 62, 13, 3, 6000, '2024-12-23 05:08:09', '2024-12-23 05:08:09'),
(57, 63, 7, 3, 9000, '2024-12-23 05:11:33', '2024-12-23 05:11:33'),
(58, 63, 18, 2, 3000, '2024-12-23 05:11:33', '2024-12-23 05:11:33'),
(59, 63, 16, 1, 11000, '2024-12-23 05:11:33', '2024-12-23 05:11:33'),
(60, 64, 13, 3, 6000, '2025-01-08 22:54:07', '2025-01-08 22:54:07'),
(61, 65, 13, 3, 6000, '2025-01-08 23:11:55', '2025-01-08 23:11:55'),
(62, 66, 10, 4, 12000, '2025-01-08 23:21:03', '2025-01-08 23:21:03'),
(63, 66, 16, 1, 11000, '2025-01-08 23:21:03', '2025-01-08 23:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stok` int(255) NOT NULL,
  `harga_beli` bigint(20) NOT NULL,
  `harga_jual` bigint(20) NOT NULL,
  `pemasok_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `market_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `kode_barang`, `image`, `nama_barang`, `satuan`, `stok`, `harga_beli`, `harga_jual`, `pemasok_id`, `keterangan`, `market_id`, `created_at`, `updated_at`) VALUES
(7, '29128', 'default.png', 'bismillah', '1 kg', 197, 2000, 3000, NULL, 'tersedia', 1, '2024-10-29 05:22:20', '2024-12-23 05:11:33'),
(9, '22010', 'default.png', 'caos coklat', '1 kg', 4, 2000, 4000, NULL, 'tersedia', 1, '2024-10-29 05:30:09', '2024-12-03 02:38:50'),
(10, '10902', '1734168166.png', 'mencoba update', '10 kg', 155, 1000, 3000, NULL, 'tersedia', 1, '2024-10-29 05:33:48', '2025-01-08 23:21:03'),
(12, '983293', '1734373772.png', 'hjasa', '100 kg', 99, 1000, 2000, NULL, 'tersedia', 2, '2024-10-30 09:51:45', '2024-12-20 11:06:38'),
(13, '9283293', 'default.png', 'dhcp', '10 saschet', 883, 10002, 2000, NULL, 'tersedia', 1, '2024-10-30 10:15:14', '2025-01-08 23:11:55'),
(15, '10292012', '241128112831.png', 'kacang garuda', '1 pcs', 276, 5000, 6000, NULL, 'tersedia', 2, '2024-11-28 04:28:31', '2024-12-23 02:22:56'),
(16, '4987176076649', 'default.png', 'pattene miracles', '1 pcs', 30, 10000, 11000, NULL, 'tersedia', 1, '2024-12-01 01:16:03', '2025-01-08 23:21:03'),
(17, '92129', 'default.png', 'coba gram', '1 Gram', 69, 1000, 2000, NULL, 'tersedia', 2, '2024-12-16 07:26:27', '2024-12-23 02:38:28'),
(18, '18981', 'default.png', 'Sukro', '1 KG', 94, 1000, 1500, NULL, 'tersedia', 1, '2024-12-20 21:29:04', '2024-12-23 05:11:33'),
(19, '18291', '1734755428.png', 'Sukro', '1 pcs', 50, 1000, 1500, NULL, 'tersedia', 3, '2024-12-20 21:29:59', '2024-12-20 21:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `satuans`
--

CREATE TABLE `satuans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuans`
--

INSERT INTO `satuans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'KG', NULL, NULL),
(2, 'Gram', NULL, NULL),
(4, 'pcs', '2024-12-16 07:29:06', '2024-12-16 07:29:06'),
(5, 'Kardus', '2024-12-21 04:24:55', '2024-12-21 04:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `harga_beli` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `pemasok` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `bayar` bigint(20) NOT NULL,
  `kembali` bigint(20) NOT NULL,
  `market_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `kode_transaksi`, `total_harga`, `diskon`, `bayar`, `kembali`, `market_id`, `created_at`, `updated_at`, `status`, `metode`) VALUES
(1, 2, '10292012', 100000, 0, 100000, 0, 1, '2024-10-02 15:19:03', '2024-10-02 15:19:03', 'pending', NULL),
(2, 2, '7878666', 60000, 0, 100000, 40000, 1, '2024-10-02 15:21:27', '2024-10-02 15:21:27', 'pending', NULL),
(3, 2, '7898676', 80000, 0, 100000, 20000, 2, '2024-10-28 15:41:11', '2024-10-28 15:41:11', 'pending', NULL),
(4, 4, 'OPMHJHHNV8', 71541, 0, 93812, 36643, 2, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(5, 4, 'QDYDQZUBGQ', 160108, 0, 169683, 31921, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(6, 4, 'WOHQLCLJSV', 80905, 0, 157043, 38172, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(7, 4, 'ZY9YXLNNMI', 78300, 0, 92781, 49568, 2, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(8, 4, '8WM29BHTW7', 139831, 0, 110236, 49011, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(9, 4, 'KZNTY8F3IP', 131970, 0, 136560, 10862, 2, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(10, 4, 'QUTG7ONE2B', 145948, 0, 147097, 26208, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(11, 4, 'GHB0IMTTFA', 89444, 0, 112101, 11744, 2, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(12, 4, 'Z0C5PBBJVI', 139155, 0, 191108, 29009, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(13, 4, 'CMJJ6SPHFI', 173114, 0, 67699, 6682, 1, '2024-11-04 22:04:02', '2024-11-04 22:04:02', 'pending', NULL),
(15, 4, 'T03122024093137', 15000, 0, 20000, 5000, 1, '2024-12-03 02:31:41', '2024-12-03 02:31:41', 'pending', NULL),
(16, 4, 'T03122024093308', 15000, 0, 20000, 5000, 1, '2024-12-03 02:33:46', '2024-12-03 02:33:46', 'pending', NULL),
(17, 4, 'T03122024093440', 12000, 0, 15000, 3000, 1, '2024-12-03 02:34:47', '2024-12-03 02:34:47', 'pending', NULL),
(18, 4, 'T03122024093447', 3000, 0, 4000, 1000, 1, '2024-12-03 02:37:57', '2024-12-03 02:37:57', 'pending', NULL),
(19, 4, 'T03122024093842', 4000, 0, 5000, 1000, 1, '2024-12-03 02:38:50', '2024-12-03 02:38:50', 'pending', NULL),
(20, 4, 'T03122024113234', 8100, 10, 10000, 1900, 1, '2024-12-03 04:32:55', '2024-12-03 04:32:55', 'pending', NULL),
(21, 4, 'T03122024113255', 16320, 4, 17000, 680, 1, '2024-12-03 04:34:15', '2024-12-03 04:34:15', 'pending', NULL),
(22, 5, 'T03122024122515', 22000, 0, 30000, 8000, 1, '2024-12-03 05:37:10', '2024-12-03 05:37:10', 'pending', NULL),
(23, 4, 'T05122024080057', 6000, 0, 10000, 4000, 1, '2024-12-05 01:01:08', '2024-12-05 01:01:08', 'pending', NULL),
(24, 4, 'T05122024080519', 30000, 0, 40000, 10000, 1, '2024-12-05 01:05:36', '2024-12-05 01:05:36', 'pending', NULL),
(25, 4, 'T05122024083314', 30600, 10, 40000, 9400, 1, '2024-12-05 01:37:07', '2024-12-05 01:37:07', 'pending', NULL),
(26, 4, 'T05122024084042', 9000, 10, 10000, 1900, 1, '2024-12-05 01:41:00', '2024-12-05 01:41:00', 'pending', NULL),
(27, 4, 'T05122024084250', 44000, 10, 40000, 400, 1, '2024-12-05 01:43:04', '2024-12-05 01:43:04', 'pending', NULL),
(28, 4, 'T05122024084335', 24000, 10, 25000, 3400, 1, '2024-12-05 01:43:56', '2024-12-05 01:43:56', 'pending', NULL),
(29, 4, 'T05122024084524', 80000, 30, 60000, 4000, 1, '2024-12-05 01:45:38', '2024-12-05 01:45:38', 'pending', NULL),
(30, 4, 'T20122024180545', 10000, 10, 10000, 1000, 1, '2024-12-20 11:06:38', '2024-12-20 11:06:38', 'pending', NULL),
(31, 4, 'T23122024072045', 22000, 0, 22000, 0, 1, '2024-12-23 00:21:45', '2024-12-23 00:21:45', 'pending', NULL),
(32, 4, 'T23122024073236', 6000, 0, 6000, 0, 1, '2024-12-23 00:32:40', '2024-12-23 00:32:40', 'pending', NULL),
(33, 4, 'T23122024073241', 4000, 0, 4000, 0, 1, '2024-12-23 00:35:05', '2024-12-23 00:35:05', 'pending', NULL),
(34, 4, 'T23122024073654', 10000, 0, 10000, 0, 1, '2024-12-23 00:37:03', '2024-12-23 00:37:03', 'pending', NULL),
(35, 4, 'T23122024073914', 4000, 0, 4000, 0, 1, '2024-12-23 00:39:21', '2024-12-23 00:39:21', 'pending', NULL),
(36, 4, 'T23122024075419', 12000, 0, 12000, 0, 1, '2024-12-23 00:54:29', '2024-12-23 00:54:29', 'pending', NULL),
(37, 4, 'T23122024075848', 18000, 0, 18000, 0, 1, '2024-12-23 00:59:49', '2024-12-23 00:59:49', 'pending', NULL),
(38, 4, 'T23122024080235', 12000, 0, 12000, 0, 1, '2024-12-23 01:02:46', '2024-12-23 01:02:46', 'pending', NULL),
(39, 4, 'T23122024080422', 12000, 0, 12000, 0, 1, '2024-12-23 01:04:32', '2024-12-23 01:04:32', 'pending', NULL),
(40, 4, 'T23122024080702', 3000, 0, 3000, 0, 1, '2024-12-23 01:07:27', '2024-12-23 01:07:27', 'pending', NULL),
(41, 4, 'T23122024080811', 6000, 0, 6000, 0, 1, '2024-12-23 01:08:39', '2024-12-23 01:08:39', 'pending', NULL),
(42, 4, 'T23122024080959', 3000, 0, 3000, 0, 1, '2024-12-23 01:10:05', '2024-12-23 01:10:05', 'pending', NULL),
(43, 4, 'T23122024081151', 4000, 0, 4000, 0, 1, '2024-12-23 01:11:58', '2024-12-23 01:11:58', 'pending', NULL),
(44, 4, 'T23122024081253', 22000, 0, 22000, 0, 1, '2024-12-23 01:13:02', '2024-12-23 01:13:02', 'pending', NULL),
(45, 4, 'T23122024082452', 4000, 0, 4000, 0, 1, '2024-12-23 01:24:57', '2024-12-23 01:24:57', 'pending', NULL),
(46, 4, 'T23122024082630', 12000, 0, 12000, 0, 1, '2024-12-23 01:26:36', '2024-12-23 01:26:36', 'pending', NULL),
(47, 4, 'T23122024083446', 4000, 0, 4000, 0, 1, '2024-12-23 01:34:55', '2024-12-23 01:34:55', 'pending', NULL),
(48, 4, 'T23122024083932', 18000, 0, 18000, 0, 1, '2024-12-23 01:39:38', '2024-12-23 01:39:38', 'pending', NULL),
(49, 4, 'T23122024084058', 12000, 0, 12000, 0, 1, '2024-12-23 01:41:05', '2024-12-23 01:41:05', 'pending', NULL),
(50, 4, 'T23122024085109', 6000, 0, 6000, 0, 1, '2024-12-23 01:51:15', '2024-12-23 01:51:15', 'pending', NULL),
(51, 4, 'T23122024091713', 4000, 0, 4000, 0, 1, '2024-12-23 02:17:19', '2024-12-23 02:17:19', 'pending', NULL),
(52, 4, 'T23122024091720', 18000, 0, 20000, 2000, 1, '2024-12-23 02:22:56', '2024-12-23 02:22:56', 'pending', NULL),
(53, 4, 'T23122024092720', 4000, 0, 5000, 1000, 1, '2024-12-23 02:27:28', '2024-12-23 02:27:28', 'pending', NULL),
(54, 4, 'T23122024092728', 4000, 0, 4000, 0, 1, '2024-12-23 02:27:37', '2024-12-23 02:27:37', 'pending', NULL),
(55, 4, 'T23122024092849', 4000, 0, 4000, 0, 1, '2024-12-23 02:28:55', '2024-12-23 02:28:55', 'pending', NULL),
(56, 4, 'T23122024092947', 4000, 0, 4000, 0, 1, '2024-12-23 02:29:53', '2024-12-23 02:29:53', 'pending', NULL),
(57, 4, 'T23122024093821', 4000, 0, 5000, 1000, 1, '2024-12-23 02:38:28', '2024-12-23 02:38:28', 'completed', 'manual'),
(58, 4, 'T23122024114611', 6000, 0, 6000, 0, 1, '2024-12-23 04:46:22', '2024-12-23 04:46:22', 'pending', 'electronic'),
(59, 4, 'T23122024114623', 9000, 0, 9000, 0, 1, '2024-12-23 04:50:11', '2024-12-23 04:50:11', 'pending', 'electronic'),
(60, 4, 'T23122024120128', 9000, 0, 9000, 0, 1, '2024-12-23 05:01:47', '2024-12-23 05:01:47', 'pending', 'electronic'),
(61, 4, 'T23122024120416', 6000, 0, 6000, 0, 1, '2024-12-23 05:04:46', '2024-12-23 05:05:18', 'completed', 'electronic'),
(62, 4, 'T23122024120447', 6000, 10, 5400, 0, 1, '2024-12-23 05:08:09', '2024-12-23 05:08:38', 'completed', 'electronic'),
(63, 4, 'T23122024121057', 23000, 10, 20700, 0, 1, '2024-12-23 05:11:33', '2024-12-23 05:12:09', 'completed', 'electronic'),
(64, 4, 'T09012025055357', 6000, 0, 6000, 0, 1, '2025-01-08 22:54:07', '2025-01-08 22:54:07', 'pending', 'electronic'),
(65, 4, 'T09012025060248', 6000, 0, 6000, 0, 1, '2025-01-08 23:11:54', '2025-01-08 23:11:54', 'pending', 'electronic'),
(66, 4, 'T09012025061155', 23000, 0, 25000, 2000, 1, '2025-01-08 23:21:03', '2025-01-08 23:21:03', 'completed', 'manual');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_karyawan`, `foto`, `email_verified_at`, `password`, `role`, `market_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'dona', 'dona@gmail.com', '102210023', 'default.png', NULL, '$2y$12$ad0NkU6lOfYkWDXR2ewZzOVJEyKpsfstKvbql.NapUDULmu/p4/Su', 'admin', 1, NULL, '2024-10-22 05:18:58', '2024-10-22 05:18:58'),
(5, 'kasir', 'kasir@kasir.com', '102210024', 'default.png', NULL, '$2y$12$ad0NkU6lOfYkWDXR2ewZzOVJEyKpsfstKvbql.NapUDULmu/p4/Su', 'kasir', 1, NULL, NULL, NULL),
(6, 'kasir2', 'kasir2@gmail.com', '198272', 'default.png', NULL, '$2y$12$zlz7dmG22W4zjIzOI9jebeO2XBIhXD75cl.CR7wCf2gELj2bkwxhm', 'kasir', 1, NULL, '2024-12-10 01:20:21', '2024-12-10 01:20:21'),
(7, 'kembali', 'kembali@gmail.com', '089878', 'default.png', NULL, '$2y$12$8n/LZjRfr7zLDiaedRH5AOHzJbC6c8zDDJyFBMHgvZL.VcgaI0G7C', 'kasir', 3, NULL, '2024-12-20 21:06:09', '2024-12-20 21:06:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_product_category_id_foreign` (`category_id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_no_karyawan_unique` (`no_karyawan`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `markets_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_karyawan_unique` (`no_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `satuans`
--
ALTER TABLE `satuans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
