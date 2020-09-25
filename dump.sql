-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table freeback.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.admins: ~0 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `email`, `name`, `password`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin@freeback.com', 'Fb Admin', '$2y$10$T6/sI.I/Rj2MRBCdsLYoX.SnhflJqzukhRmkFMY9SLY5BmgR9rMve', 1, NULL, '2019-11-22 17:16:23', '2019-11-22 17:16:23');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- Dumping structure for table freeback.cashback_requests
CREATE TABLE IF NOT EXISTS `cashback_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `import` double(8,2) NOT NULL,
  `iban` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('accepted','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'accepted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.cashback_requests: ~0 rows (approximately)
/*!40000 ALTER TABLE `cashback_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashback_requests` ENABLE KEYS */;

-- Dumping structure for table freeback.cash_desks
CREATE TABLE IF NOT EXISTS `cash_desks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_branch_id` int(10) unsigned NOT NULL,
  `desk_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_desks_code_unique` (`code`),
  KEY `cash_desks_store_branch_id_foreign` (`store_branch_id`),
  CONSTRAINT `cash_desks_store_branch_id_foreign` FOREIGN KEY (`store_branch_id`) REFERENCES `store_branches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.cash_desks: ~0 rows (approximately)
/*!40000 ALTER TABLE `cash_desks` DISABLE KEYS */;
INSERT INTO `cash_desks` (`id`, `store_branch_id`, `desk_name`, `code`, `active`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Cassa 1', 'C-31778', 1, '2019-11-22 17:55:03', '2019-11-22 17:55:03');
/*!40000 ALTER TABLE `cash_desks` ENABLE KEYS */;

-- Dumping structure for table freeback.cash_invoices
CREATE TABLE IF NOT EXISTS `cash_invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `total` double(8,2) NOT NULL,
  `freeback_fee` double(8,2) NOT NULL,
  `cashback_fee` double(8,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cash_invoices_invoice_number_unique` (`invoice_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.cash_invoices: ~0 rows (approximately)
/*!40000 ALTER TABLE `cash_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `cash_invoices` ENABLE KEYS */;

-- Dumping structure for table freeback.cash_transactions
CREATE TABLE IF NOT EXISTS `cash_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `branch_id` int(10) unsigned NOT NULL,
  `cash_desk_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `full_import` double(8,2) NOT NULL,
  `discount_rate` double(8,2) NOT NULL,
  `freeback_rate` double(8,2) NOT NULL,
  `cashback_neto` double(8,2) NOT NULL,
  `freeback_neto` double(8,2) NOT NULL,
  `status` enum('accepted','declined','sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `cash_invoice_id` int(10) unsigned DEFAULT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT '0',
  `royalty_check` tinyint(1) NOT NULL DEFAULT '0',
  `invoiced` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_transactions_store_id_foreign` (`store_id`),
  KEY `cash_transactions_branch_id_foreign` (`branch_id`),
  KEY `cash_transactions_cash_desk_id_foreign` (`cash_desk_id`),
  CONSTRAINT `cash_transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `store_branches` (`id`),
  CONSTRAINT `cash_transactions_cash_desk_id_foreign` FOREIGN KEY (`cash_desk_id`) REFERENCES `cash_desks` (`id`),
  CONSTRAINT `cash_transactions_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.cash_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `cash_transactions` DISABLE KEYS */;
INSERT INTO `cash_transactions` (`id`, `store_id`, `branch_id`, `cash_desk_id`, `user_id`, `full_import`, `discount_rate`, `freeback_rate`, `cashback_neto`, `freeback_neto`, `status`, `cash_invoice_id`, `notified`, `royalty_check`, `invoiced`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 1, 100.00, 1.00, 30.00, 0.70, 0.30, 'sent', NULL, 0, 0, 0, '2019-11-22 19:59:42', '2019-11-22 19:59:42');
/*!40000 ALTER TABLE `cash_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.cities: ~144 rows (approximately)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `city_name`, `country_id`, `created_at`, `updated_at`) VALUES
	(1, 'Roma', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(2, 'Milano', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(3, 'Napoli', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(4, 'Torino', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(5, 'Palermo', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(6, 'Genova', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(7, 'Bologna', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(8, 'Firenze', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(9, 'Bari', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(10, 'Catania', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(11, 'Venezia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(12, 'Verona', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(13, 'Messina', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(14, 'Padova', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(15, 'Trieste', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(16, 'Taranto', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(17, 'Parma', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(18, 'Brescia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(19, 'Prato', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(20, 'Modena', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(21, 'Reggio Calabria', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(22, 'Reggio nell\'Emilia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(23, 'Perugia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(24, 'Ravenna', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(25, 'Livorno', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(26, 'Cagliari', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(27, 'Foggia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(28, 'Rimini', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(29, 'Salerno', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(30, 'Ferrara', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(31, 'Sassari', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(32, 'Latina', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(33, 'Giugliano in Campania', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(34, 'Monza', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(35, 'Siracusa', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(36, 'Bergamo', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(37, 'Pescara', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(38, 'Trento', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(39, 'Forlì', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(40, 'Vicenza', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(41, 'Terni', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(42, 'Bolzano', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(43, 'Novara', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(44, 'Piacenza', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(45, 'Ancona', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(46, 'Andria', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(47, 'Udine', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(48, 'Arezzo', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(49, 'Cesena', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(50, 'Lecce', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(51, 'Pesaro', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(52, 'Barletta', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(53, 'Alessandria', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(54, 'La Spezia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(55, 'Pistoia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(56, 'Pisa', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(57, 'Catanzaro', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(58, 'Lucca', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(59, 'Brindisi', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(60, 'Torre del Greco', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(61, 'Treviso', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(62, 'Busto Arsizio', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(63, 'Como', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(64, 'Marsala', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(65, 'Grosseto', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(66, 'Sesto San Giovanni', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(67, 'Pozzuoli', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(68, 'Varese', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(69, 'Fiumicino', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(70, 'Casoria', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(71, 'Corigliano-Rossano', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(72, 'Asti', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(73, 'Cinisello Balsamo', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(74, 'Caserta', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(75, 'Gela', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(76, 'Aprilia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(77, 'Ragusa', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(78, 'Pavia', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(79, 'Cremona', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(80, 'Carpi', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(81, 'Quartu Sant\'Elena', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(82, 'Lamezia Terme', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(83, 'Altamura', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(84, 'Imola', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(85, 'L\'Aquila', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(86, 'Massa', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(87, 'Trapani', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(88, 'Viterbo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(89, 'Cosenza', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(90, 'Potenza', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(91, 'Castellammare di Stabia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(92, 'Afragola', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(93, 'Vittoria', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(94, 'Crotone', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(95, 'Pomezia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(96, 'Vigevano', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(97, 'Carrara', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(98, 'Caltanissetta', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(99, 'Viareggio', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(100, 'Fano', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(101, 'Savona', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(102, 'Matera', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(103, 'Olbia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(104, 'Legnano', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(105, 'Acerra', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(106, 'Marano di Napoli', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(107, 'Benevento', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(108, 'Molfetta', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(109, 'Agrigento', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(110, 'Faenza', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(111, 'Cerignola', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(112, 'Moncalieri', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(113, 'Foligno', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(114, 'Manfredonia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(115, 'Tivoli', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(116, 'Cuneo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(117, 'Trani', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(118, 'Bisceglie', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(119, 'Bitonto', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(120, 'Bagheria', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(121, 'Anzio', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(122, 'Portici', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(123, 'Modica', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(124, 'Sanremo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(125, 'Avellino', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(126, 'Teramo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(127, 'Montesilvano', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(128, 'Siena', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(129, 'Gallarate', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(130, 'Velletri', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(131, 'Cava de\' Tirreni', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(132, 'San Severo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(133, 'Aversa', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(134, 'Ercolano', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(135, 'Civitavecchia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(136, 'Acireale', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(137, 'Mazara del Vallo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(138, 'Rovigo', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(139, 'Pordenone', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(140, 'Battipaglia', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(141, 'Rho', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(142, 'Chieti', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(143, 'Scafati', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(144, 'Scandicci', 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Dumping structure for table freeback.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_prefix` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.countries: ~0 rows (approximately)
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (`id`, `country_name`, `language_name`, `iso_code`, `phone_prefix`, `created_at`, `updated_at`) VALUES
	(1, 'Italia', 'Italiano', 'IT', '+39', '2019-11-22 17:16:22', '2019-11-22 17:16:22');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

-- Dumping structure for table freeback.disputes
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.disputes: ~0 rows (approximately)
/*!40000 ALTER TABLE `disputes` DISABLE KEYS */;
/*!40000 ALTER TABLE `disputes` ENABLE KEYS */;

-- Dumping structure for table freeback.drop_pay_configurations
CREATE TABLE IF NOT EXISTS `drop_pay_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_in` int(10) unsigned NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.drop_pay_configurations: ~0 rows (approximately)
/*!40000 ALTER TABLE `drop_pay_configurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `drop_pay_configurations` ENABLE KEYS */;

-- Dumping structure for table freeback.faqs
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'it',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.faqs: ~38 rows (approximately)
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` (`id`, `question`, `answer`, `active`, `lang`, `created_at`, `updated_at`) VALUES
	(1, 'Per effettuare un acquisto devo essere registrato?', 'Si, per effettuare un acquisto devi registrarti. Potrai seguire l\'arrivo del tuo ordine dalla tua area personale, gestire i tuoi acquisti e richiedere assistenza dopo la vendita qualora necessario. Se non lo hai ancora fatto, puoi registrarti cliccando sull\\\'apposito link.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(2, 'Come faccio a effettuare un acquisto?', 'Fare un ordine online è facilissimo:\r\n1 - Cerca il prodotto che desideri con la ricerca o navigando tra i negozi\r\n2 - Scegli quello che fa per te e aggiungilo al carrello\r\n3 - compila i tuoi dati e conferma l\'ordine.\r\nRiceverai una email di conferma con i dati del tuo ordine e i prossimi passi. Potrai seguire la consegna dalla tua area personale e riceverai tutti gli aggiornamenti via email e telefono', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(3, 'Come faccio a sapere se il mio ordine è stato inserito correttamente?', 'Il tuo nuovo ordine appare subito nella tua area personale nella sezione "i Tuoi Ordini", in cui trovi tutti i dati e info sulla consegna\r\nTi inviamo inoltre un\'email di conferma con tutti i dati dell\'ordine. Se non la ricevi controlla nella posta indesiderata.\r\nSe nella tua area personale non è presente il nuovo ordine e non hai ricevuto l\'email di conferma, è probabile che l\'ordine non sia stato correttamente inserito.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(4, 'I prezzi sono comprensivi di IVA?', 'Tutti i prezzi sono da intendersi come prezzi al pubblico e, quindi, comprensivi di IVA ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(5, 'Posso avere la fattura intestata all’azienda?', 'Certo, quando nel carrello ti vengono richiesti i dati di fatturazione, puoi scegliere se intestare la fattura a una persona fisica o a un\'azienda (o libero professionista con partita IVA). Se hai già effettuato l\'ordine ma non è ancora stato spedito puoi richiedere al nostro servizio clienti la modifica dei dati. Ricorda che se acquisti come azienda o libero professionista, non potrai avvalerti del Diritto di Recesso.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(6, 'Cos’è il Marketplace?', 'Il Marketplace è un servizio che permette ai migliori brand e venditori professionali di vendere i propri prodotti sul sito Freeback. Nel dettaglio del prodotto che hai scelto è sempre indicato se il prodotto è venduto direttamente da Freeback o da un venditore del marketplace.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(7, 'È possibile acquistare più prodotti da un solo venditore?', 'Sì. Scegli comodamente tutti i prodotti che desideri acquistare. Le spese non sono una semplice somma matematica, ma un calcolo ponderato che considera le quantità e il peso/volume dei prodotti scelti. Potrai vedere il costo di spedizione applicato all’ordine nel carrello, prima di confermare l’acquisto.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(8, 'È possibile acquistare contemporaneamente prodotti da più venditori?', 'Sì, puoi creare dei carrelli misti, mediante un unico pagamento. Tieni presente che le spedizioni saranno poi effettuate, gestite e addebitate sulla tua carta di pagamento come ordini indipendenti dei diversi venditori, con date di consegna differenti ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(9, 'Freeback è responsabile del comportamento dei venditori del Marketplace?', 'Freeback non è direttamente responsabile del comportamento dei venditori del Marketplace, ma il contratto stipulato in fase di iscrizione contiene obblighi e diritti, che tutelano in ogni momento il consumatore finale. Qualora insorgessero difficoltà tra venditori e acquirenti, Freeback ha messo a punto un Programma di Protezione Clienti, che si applica a tutti i casi in cui gli acquirenti possono avere difficoltà con i venditori, come la mancata consegna, i prodotti difettosi o non conformi alla descrizione o i mancati rimborsi.\r\nTale programma si attiva automaticamente nel momento in cui l’acquirente invia un reclamo a fronte di un reso/rimborso non eseguito.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(10, 'Posso lasciare un feedback sul venditore?', 'Una volta ricevuto il tuo ordine, se vuoi, puoi lasciare la tua valutazione sul venditore da cui hai acquistato il prodotto.  ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(11, 'Quanto costa la consegna?', 'I prezzi dipendono dal tipo di consegna scelta, dal peso/volume dei prodotti acquistati, dal luogo di consegna e dipendono dalle politiche di vendita dei venditori. Per ciascun prodotto potrai conoscere i costi della consegna aggiungendolo al carrello dopo aver compilato i dati di fatturazione e spedizione, prima della conferma dell\'ordine.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(12, 'Come posso tracciare la spedizione del mio ordine?', 'Puoi tracciare la spedizione del tuo ordine andando nel dettaglio dell’ordine cliccando su "Traccia Dettaglio Spedizione"  ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(13, 'Le transazioni con carta di credito sono sicure?', 'Sì, i pagamenti effettuati con Carta di Credito sul nostro sito sono criptati e dunque sicuri.\r\nPer salvaguardare la tua privacy e la sicurezza, infatti, quando ti registri ed inserisci la tua carta di credito o quando procedi al pagamento con carta di credito, viene utilizzato un sistema di pagamento sicuro, garantito dal certificato VeriSign. I dati della tua carta di credito vengono trasmessi, tramite una connessione protetta in crittografia SSL (Secure Socket Layer), direttamente a Banca Sella, per l\'autorizzazione e l\'addebito. Questo vuol dire che non siamo in grado, in nessun momento della procedura di acquisto e in nessun caso, di conoscere informazioni personali relative al titolare né il numero della carta. A noi giungerà soltanto l\'autorizzazione fornita dal gestore della carta.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(14, 'Perché è stata rifiutata la mia carta di credito?', 'Può accadere che la tua carta di credito non venga accettata per questi motivi:\r\nÈ possibile che tu abbia oltrepassato il limite di credito. La tua banca può darti tutte le informazioni necessarie sulla tua carta e sulle possibilità di pagamento.\r\nI dati richiesti per il pagamento non coincidono con quelli tua carta. Un semplice errore tipografico in uno dei campi, può causare il rifiuto dell\'operazione.\r\nLa tua carta di credito è scaduta, controlla la data di scadenza, la trovi sulla carta stessa.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(15, '\r\nQuando sarà effettuato l’addebito sulla mia Carta di Credito?', 'L\'importo relativo all\'acquisto effettuato verrà addebitato sulla tua carta di credito al momento della conferma dell\'ordine. L\'addebito sul tuo conto seguirà i tempi stabiliti dal gestore della carta. Contatta la tua banca per ulteriori informazioni.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(16, '\r\nPosso annullare un ordine il cui pagamento è stato effettuato con carta di credito?', 'Sì, se il tuo ordine non è ancora stato spedito puoi richiedere l\'annullamento direttamente dal dettaglio dell\'ordine nell\'area personale del sito. In seguito alla conferma di annullamento, verrà automaticamente stornata la transazione direttamente sulla tua carta di credito.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(17, 'Ho cambiato idea su un prodotto. Posso restituirlo?', 'Se dovessi cambiare idea o sfortunatamente dovessero esserci dei problemi, puoi decidere di restituire il prodotto acquistato con le modalità specificate dal venditore.\r\nLa richiesta di recesso deve pervenire entro 14 giorni di calendario dalla ricezione dell\'ordine e puoi inserirla direttamente dal dettaglio del tuo ordine, cliccando su Richiedi reso.\r\nIl diritto di recesso si applica solo ai consumatori, ovvero persone fisiche che agiscono per scopi estranei all’attività imprenditoriale o professionale eventualmente svolta.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(18, 'Ho acquistato con partita IVA e ho cambiato idea su un prodotto. Posso restituirlo?', 'Il Diritto di Recesso è regolato dal Codice del Consumo e riguarda solo le compravendite a distanza tra il venditore e i consumatori privati non professionali. Pertanto, se sei una partita IVA o un\'azienda, non puoi avvalerti del diritto di recesso. Per maggiori informazioni, consulta la pagina del Diritto di recesso.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(19, 'Ho ricevuto un prodotto sbagliato', 'Scegli l\'ordine per il quale hai riscontrato il problema e rivolgiti direttamente al venditore. Il nostro Servizio Clienti, in ogni caso, sarà sempre pronto ad aiutarti per qualsiasi problema. ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(20, 'Nel mio pacco manca un articolo. Cosa devo fare?', 'Scegli l\'ordine per il quale hai riscontrato il problema e rivolgiti direttamente al venditore. Il nostro Servizio Clienti, in ogni caso, sarà sempre pronto ad aiutarti per qualsiasi problema', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(21, 'Ho ricevuto un prodotto sbagliato. Cosa devo fare?', 'Scegli l\'ordine per il quale hai riscontrato il problema, clicca su "Articolo errato/danneggiato".\r\nSeleziona il prodotto per cui vuoi fare la segnalazione e segui la procedura guidata.  Il nostro Servizio Clienti ti risponderà al più presto.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(22, 'Nel mio pacco manca un articolo. Cosa devo fare?', 'Scegli l\'ordine per il quale hai riscontrato il problema, clicca su "Articolo errato/danneggiato". Seleziona il prodotto per cui vuoi fare la segnalazione e segui la procedura guidata.  Il nostro Servizio Clienti ti risponderà al più presto.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(23, 'Sto aspettando un rimborso sulla mia carta di credito, quanto tempo ci vuole?', 'Per rimborsi effettuati su carta di credito, le tempistiche di riaccredito dell\'importo sono dipendenti dal circuito emittente della carta, indicativamente 5-10 giorni lavorativi da quando riceverai la comunicazione che conferma lo storno. Per informazioni più precise ti consigliamo di contattare l\'assistenza clienti della tua carta di credito.\r\nNel caso tu abbia effettuato un reso, il rimborso viene effettuato solo ad avvenuta ricezione e verifica dei prodotti resi presso il nostro magazzino.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(24, 'Ho cambiato idea su un prodotto, posso restituirlo?', 'Certo, se dovessi cambiare idea puoi esercitare il diritto di recesso, informando direttamente il venditore entro 14 giorni dalla consegna della merce, puoi inserire la richiesta direttamente dal dettaglio del tuo ordine, cliccando su Richiedi reso.  \r\nIl diritto di recesso si applica solo ai consumatori, ovvero persone fisiche che agiscono per scopi estranei all’attività imprenditoriale o professionale eventualmente svolta. Per maggiori informazioni, consulta la pagina del Diritto di Reccesso.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(25, 'Come posso esercitare il diritto di recesso?', 'Per esercitare il diritto di recesso, sei tenuto a informare il venditore della tua decisione entro 14 giorni dalla consegna della merce tramite la funzione Richiedi reso, disponibile nella pagina di dettaglio ordine nella tua Area Personale, scegliendo come motivazione Diritto di recesso.\r\nSe necessario sarai contattato dal venditore per informazioni aggiuntive e indicazioni sul rimborso.\r\nTi suggeriamo di contattare sempre il venditore per ogni dubbio o domanda in merito.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(26, 'L’oggetto che ho acquistato risulta danneggiato/difettoso/non conforme.', 'Se l’oggetto da te acquistato dovesse risultare danneggiato, difettoso, non conforme o comunque non rispondente alle tue aspettative, puoi contattare il venditore che eventualmente provvederà a sostituirlo. Accedi alla pagina di  dettaglio dell’ordine nella tua area personale e utilizza la funzione Richiedi reso, indicando la motivazione per cui stai inviando la richiesta. Sarai contattato dal venditore per informazioni aggiuntive o indicazioni sul reso. In alternativa puoi esercitare il diritto di recesso comunicandolo al venditore entro 14 giorni da quando i prodotti ti vengono consegnati.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(27, 'Ho inviato una richiesta di reso al venditore ma non mi ha risposto.', 'Se hai inviato la richiesta al venditore utilizzando l’apposita funzione Richiedi reso nel dettaglio prodotto e il venditore non ti risponde entro 7 giorni, puoi segnalarlo a Freeback attivando la funzione Invia reclamo. Potrai mandare un messaggio al nostro Servizio Clienti che interverrà per approfondire il problema. ', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(28, 'Non ho ricevuto il mio ordine e il venditore non mi ha rimborsato.', 'Qualora non ricevessi il prodotto che hai ordinato, puoi accedere alla scheda dell’ordine per sapere se l’ordine è stato spedito e quando è prevista la consegna. In caso di mancata consegna puoi cliccare sul tasto Richiedi reso, con il quale puoi segnalare al venditore la non avvenuta consegna dell’ordine e la richiesta di rimborso.\r\nIn caso di mancato riscontro dal venditore entro 7 giorni, puoi segnalarlo a Freeback utilizzando la funzione Invia reclamo presente nel dettaglio ordine.\r\nRicorda che per inviare un reclamo a Freeback, devi aver effettivamente inoltrato la richiesta di reso/rimborso al venditore, e tale richiesta dev’essere rimasta inevasa.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(29, 'L\'ordine è spedito data di consegna ma prevista è passata, cosa posso fare?', 'Se la data di prevista consegna è passata ed il prodotto non è stato consegnato puoi consultare il tracking della spedizione accedendo al dettaglio ordine.Ti invitiamo ad attendere 1/2 giorni lavorativi prima di contattarci, perchè può accadere che il corriere abbia un piccolo ritardo. Nel caso in cui dovessero verificarsi ritardi maggiori, ti invitiamo a contattarci per verificare lo stato della spedizione. Puoi scriverci direttamente dal dettaglio ordine, accedi ai tuoi ordini utilizzando il pulsante Scrivi al servizio clienti', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(30, 'Mi sono dimenticato la password come posso recuperarla?', 'Se hai dimenticato la tua password puoi cliccare su "Password Dimenticata". Ti sarà spedita un’e-mail per il recupero delle tue credenziali.Se non hai ricevuto l’email di recupero della password ti consigliamo di controllare nelle cartelle di posta indesiderata del tuo programma di posta elettronica.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(31, 'Posso modificare l\'email con la quale accedo all\'area personale?', 'Per modificarla accedi alla tua area personale, nella sezione "Impostazioni Account". Lì potrai indicare la tua nuova email.\r\nLa nuova email dovrà essere valida e in uso, pertanto ti manderemo un\'email con un link da cliccare come conferma.\r\n', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(32, 'Gli sconti hanno una scadenza?', 'No. Gli sconti sono decisi dai venditori e sono riservati agli Utenti di Freeback; possono variare nel tempo a seconda delle scelte commerciali dei Venditori. Controlla sempre la lo sconto riservato dal venditore per gli articoli che voi acquistare su Freeback.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(33, '\r\nGli sconti sono convertibili in denaro?', 'Si sempre !.  Gli sconti riservati dai Venditori agli Utenti di Freeback sono sempre denaro che Freeback ti metterà a disposizione sulla tua carta di debito/ credito che hai indicato al momento della tua iscrizione a Freeback.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(34, 'Come ottengo il mio rimborso degli sconti maturati', 'Per ogni acquisto che hai effettuato tramite Freeback, hai diritto a un rimborso pari a una percentuale della spesa fatta (sconto). Questa percentuale varia a seconda del negozio ed è indicata accanto al suo nome. Il rimborso ti è accreditato sul portafoglio di Freeback quando il negozio conferma il tuo avvenuto pagamento.\r\nAttenzione: Se acquisti qualcosa dimenticando di utilizzare Freeback come punto di partenza o senza effettuare l’accesso, la tua spesa non potrà essere registrata e non avrai diritto ad alcun rimborso.\r\nCompra dove vuoi e quello che vuoi ma ricordati sempre di passare da Freeback per assicurarti il tuo sconto.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(35, 'Come viene calcolata la percentuale di ogni negozio per il rimborso', 'Vorremmo offrirti il rimborso più alto possibile e lavoriamo costantemente a questo scopo ma è il Venditore a decidere quale sia la percentuale di sconto per gli utenti di Freeback.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(36, 'Quando vengo pagato?', 'Per poter incassare i tuoi rimborsi, l’unica condizione richiesta da Freeback è quella di accumulare un totale di almeno 10 Euro nel tuo salvadanaio. Raggiunta questa cifra ti basta accedere al tuo profilo e fare un click su “Incassa”. Ti verrà effettuato un bonifico sulla carta ricaricabile da te indicata all’atto dell’iscrizione detratti 0,50€ di costi di bancari per il Bonifico. Se si tratta del primo bonifico di rimborso ti verrà detratta la quota di iscrizione di Freeback pari a 6 euro annuali.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(37, 'Mi è stato annullato un rimborso perche?', 'Se il negozio dove hai acquistato annulla il tuo pagamento (ad esempio per un reso) il tuo rimborso sarà cancellato di conseguenza. Se ritieni che sia stato annullato per sbaglio un rimborso a cui pensi di avere diritto, accedi al tuo profilo e apri una segnalazione in merito. Freeback si occuperà di risolvere il tuo problema.', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23'),
	(38, 'Quando incasso il rimborso è soggetto a tassazione?', 'No. Il rimborso dei tuoi acquisti diretti non è soggetto ad alcuna tassazione e non viene praticata alcuna ritenuta.\r\nI guadagni generati dal programma "Invita un Amico" sono soggetti a ritenuta d’acconto come descritto nel contratto di abbonamento a Freeback', 1, 'it', '2019-11-22 17:16:23', '2019-11-22 17:16:23');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;

-- Dumping structure for table freeback.fees_infos
CREATE TABLE IF NOT EXISTS `fees_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_import` double(8,2) NOT NULL DEFAULT '0.00',
  `store_import` double(8,2) NOT NULL DEFAULT '0.00',
  `transaction_import` double(8,2) NOT NULL DEFAULT '30.00',
  `royalty_fee` double(8,2) NOT NULL DEFAULT '20.00',
  `minimum_requestable_import` double(8,2) NOT NULL DEFAULT '10.00',
  `currency` enum('€','$','£') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '€',
  `country_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.fees_infos: ~0 rows (approximately)
/*!40000 ALTER TABLE `fees_infos` DISABLE KEYS */;
INSERT INTO `fees_infos` (`id`, `user_import`, `store_import`, `transaction_import`, `royalty_fee`, `minimum_requestable_import`, `currency`, `country_id`, `active`, `created_at`, `updated_at`) VALUES
	(1, 0.00, 0.00, 30.00, 10.00, 10.00, '€', 1, 1, '2019-11-22 17:16:23', '2019-11-22 17:16:23');
/*!40000 ALTER TABLE `fees_infos` ENABLE KEYS */;

-- Dumping structure for table freeback.getters
CREATE TABLE IF NOT EXISTS `getters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iban` varchar(34) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referral_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees_sum` double(8,2) NOT NULL DEFAULT '0.00',
  `fee_rate` double(8,2) NOT NULL DEFAULT '10.00',
  `city_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `getters_email_unique` (`email`),
  UNIQUE KEY `getters_iban_unique` (`iban`),
  UNIQUE KEY `getters_referral_code_unique` (`referral_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.getters: ~1 rows (approximately)
/*!40000 ALTER TABLE `getters` DISABLE KEYS */;
INSERT INTO `getters` (`id`, `name`, `email`, `iban`, `referral_code`, `fees_sum`, `fee_rate`, `city_id`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'Getter1', 'getter@est.com', 'CY21002001950000357001234567', 'P-GETTER1', 0.00, 11.00, 105, 1, '2019-11-22 17:36:26', '2019-11-22 17:36:26');
/*!40000 ALTER TABLE `getters` ENABLE KEYS */;

-- Dumping structure for table freeback.getter_transactions
CREATE TABLE IF NOT EXISTS `getter_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `getter_id` int(10) unsigned NOT NULL,
  `transaction_type` enum('online','offline','cash','tradedoubler') COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` enum('transaction','fee_payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transaction',
  `status` enum('completed','error','missing_payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'missing_payment',
  `transaction_id` int(10) unsigned NOT NULL,
  `fb_fee_import` double(8,2) NOT NULL,
  `getter_fee_rate` double(8,2) NOT NULL,
  `import` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.getter_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `getter_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `getter_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `invoice_type` enum('transaction_invoice','cashback_invoice') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transaction_invoice',
  `transaction_type` enum('online','offline','cash','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `total` double(8,2) NOT NULL,
  `freeback_fee` double(8,2) NOT NULL,
  `cashback_fee` double(8,2) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.invoices: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;

-- Dumping structure for table freeback.marketing_banners
CREATE TABLE IF NOT EXISTS `marketing_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `background_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.marketing_banners: ~0 rows (approximately)
/*!40000 ALTER TABLE `marketing_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `marketing_banners` ENABLE KEYS */;

-- Dumping structure for table freeback.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.migrations: ~54 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2017_12_14_165559_create_admins_table', 1),
	(4, '2017_12_14_165609_create_stores_table', 1),
	(5, '2017_12_16_110529_create_user_bank_infos_table', 1),
	(6, '2017_12_16_111428_create_user_wallets_table', 1),
	(7, '2017_12_16_115251_create_product_categories_table', 1),
	(8, '2017_12_17_151007_create_products_table', 1),
	(9, '2017_12_17_151628_create_product_multimedia_table', 1),
	(10, '2017_12_17_152135_create_online_transactions_table', 1),
	(11, '2017_12_17_161912_create_user_favourites_table', 1),
	(12, '2017_12_17_230225_create_countries_table', 1),
	(13, '2017_12_17_230256_create_cities_table', 1),
	(14, '2017_12_17_230723_create_user_addresses_table', 1),
	(15, '2017_12_18_105144_create_store_categories_table', 1),
	(16, '2017_12_18_141856_create_store_multimedia_table', 1),
	(17, '2018_03_05_120709_create_store_visits_table', 1),
	(18, '2018_05_17_162959_create_transactions_table', 1),
	(19, '2018_05_17_164511_create_orders_table', 1),
	(20, '2018_05_18_092229_create_store_activities_table', 1),
	(21, '2018_05_18_134226_create_search_queries_table', 1),
	(22, '2018_05_18_142445_create_user_notifications_table', 1),
	(23, '2018_05_23_135841_create_store_notifications_table', 1),
	(24, '2018_06_11_161501_create_faqs_table', 1),
	(25, '2018_06_12_135155_create_fees_infos_table', 1),
	(26, '2018_06_12_135753_create_store_bank_infos_table', 1),
	(27, '2018_06_12_180345_create_store_documents_table', 1),
	(28, '2018_06_15_083542_create_invoices_table', 1),
	(29, '2018_06_22_150151_create_store_reviews_table', 1),
	(30, '2018_07_06_183904_products_favourite', 1),
	(31, '2018_07_11_160145_create_order_shipping_addresses_table', 1),
	(32, '2018_07_19_125758_create_marketing_banners_table', 1),
	(33, '2018_09_03_154329_create_store_help_requests_table', 1),
	(34, '2018_09_05_153108_create_newsletter_subscriptions_table', 1),
	(35, '2018_09_10_182409_create_user_help_requests_table', 1),
	(36, '2018_10_03_185835_create_getters_table', 1),
	(37, '2018_10_16_114005_create_user_subscriptions_table', 1),
	(38, '2018_11_07_104331_create_t_d_stores_table', 1),
	(39, '2018_11_08_100413_create_getter_transactions_table', 1),
	(40, '2018_11_08_202048_create_user_referral_transactions_table', 1),
	(41, '2018_11_08_210829_create_store_referral_transactions_table', 1),
	(42, '2018_11_11_172014_create_phone_verify_sms_table', 1),
	(43, '2018_11_15_105422_create_store_branches_table', 1),
	(44, '2018_11_15_144444_create_store_payment_configs_table', 1),
	(45, '2018_11_15_144457_create_user_payment_configs_table', 1),
	(46, '2018_11_15_173343_create_cashback_requests_table', 1),
	(47, '2018_11_17_125946_create_disputes_table', 1),
	(48, '2018_12_12_111942_create_cash_desks_table', 1),
	(49, '2018_12_12_174222_create_cash_transactions_table', 1),
	(50, '2019_01_15_162314_create_td_store_discounts_table', 1),
	(51, '2019_01_16_145802_create_cash_invoices_table', 1),
	(52, '2019_02_14_165226_create_trade_doubler_trackings_table', 1),
	(53, '2019_02_26_002702_create_t_d_transactions_table', 1),
	(54, '2019_03_27_150248_create_drop_pay_configurations_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table freeback.newsletter_subscriptions
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscriptions_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.newsletter_subscriptions: ~0 rows (approximately)
/*!40000 ALTER TABLE `newsletter_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriptions` ENABLE KEYS */;

-- Dumping structure for table freeback.online_transactions
CREATE TABLE IF NOT EXISTS `online_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `full_import` double(8,2) NOT NULL,
  `discount_rate` double(8,2) NOT NULL,
  `freeback_rate` double(8,2) NOT NULL,
  `cashback_neto` double(8,2) NOT NULL,
  `freeback_neto` double(8,2) NOT NULL,
  `status` enum('created','refused','error','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created',
  `dp_pull_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiced` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_id` int(10) unsigned NOT NULL DEFAULT '0',
  `royalty_check` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.online_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `online_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `product_quantity` int(10) unsigned NOT NULL,
  `disputable_until` date NOT NULL,
  `disputed` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('missing_payment','recieved','processed','sent','delivered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'missing_payment',
  `courier` enum('DHL','BRT','SDA','GLS','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `order_shipping_addresses_id` int(10) unsigned NOT NULL,
  `online_transaction_id` int(10) unsigned NOT NULL,
  `reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `tracking_no` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table freeback.order_shipping_addresses
CREATE TABLE IF NOT EXISTS `order_shipping_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_number` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `additional_notes` text COLLATE utf8mb4_unicode_ci,
  `invoice_details` text COLLATE utf8mb4_unicode_ci,
  `invoice_same_address` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.order_shipping_addresses: ~0 rows (approximately)
/*!40000 ALTER TABLE `order_shipping_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_shipping_addresses` ENABLE KEYS */;

-- Dumping structure for table freeback.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table freeback.phone_verify_sms
CREATE TABLE IF NOT EXISTS `phone_verify_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('sent','error','waiting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.phone_verify_sms: ~0 rows (approximately)
/*!40000 ALTER TABLE `phone_verify_sms` DISABLE KEYS */;
INSERT INTO `phone_verify_sms` (`id`, `phone_number`, `text`, `status`, `created_at`, `updated_at`) VALUES
	(1, '3874837431', 'Il tuo codice di verifica Freeback è: 5600', 'waiting', '2019-11-22 17:23:50', '2019-11-22 17:23:50');
/*!40000 ALTER TABLE `phone_verify_sms` ENABLE KEYS */;

-- Dumping structure for table freeback.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_category_id` int(10) unsigned NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `currency` enum('$','£','€') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '€',
  `store_id` int(10) unsigned NOT NULL,
  `store_internal_code` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#',
  `loaded_by` enum('vendor','scraper') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scraper',
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_available` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_store_id_foreign` (`store_id`),
  CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.products: ~0 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table freeback.products_favourite
CREATE TABLE IF NOT EXISTS `products_favourite` (
  `product_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `products_favourite_product_id_foreign` (`product_id`),
  KEY `products_favourite_user_id_foreign` (`user_id`),
  CONSTRAINT `products_favourite_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_favourite_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.products_favourite: ~0 rows (approximately)
/*!40000 ALTER TABLE `products_favourite` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_favourite` ENABLE KEYS */;

-- Dumping structure for table freeback.product_categories
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.product_categories: ~23 rows (approximately)
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
INSERT INTO `product_categories` (`id`, `name`, `slug`, `active`, `lang`, `created_at`, `updated_at`) VALUES
	(1, 'Generic', 'generic', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(2, 'Abbigliamento', 'abbigliamento', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(3, 'Scarpe e Borse', 'scarpe-e-borse', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(4, 'Alimentari e Cura della Casa', 'alimentari-e-cura-della-casa', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(5, 'Arredamento', 'arredamento', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(6, 'Farmacia e Parafarmacia', 'farmacia-e-parafarmacia', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(7, 'Abbigliamento', 'abbigliamento', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(8, 'Cancelleria e Ufficio', 'cancelleria-e-ufficio', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(9, 'Casa e Cucina', 'casa-e-cucina', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(10, 'Energia e Gas', 'energia-e-gas', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(11, 'Animali', 'animali', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(12, 'Elettronica', 'elettronica', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(13, 'Fai da Te', 'fai-da-te', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(14, 'Film e TV', 'film-e-tv', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(15, 'Giardinaggio', 'giardinaggio', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(16, 'Giochi e Giocattoli', 'giochi-e-giocattoli', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(17, 'Gioielli e Bigiotteria', 'gioielli-e-bigiotteria', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(18, 'Informatica', 'informatica', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(19, 'Libri', 'libri', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(20, 'Prima Infanzia', 'prima-infanzia', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(21, 'Servizi di Ristorazione', 'servizi-di-ristorazione', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(22, 'Strumenti Musicali', 'strumenti-musicali', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(23, 'Telefonia', 'telefonia', 1, 'it', '2019-11-22 17:16:22', '2019-11-22 17:16:22');
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;

-- Dumping structure for table freeback.product_multimedia
CREATE TABLE IF NOT EXISTS `product_multimedia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('image','video','document','web_thumb','mobile','mobile_thumb') COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_multimedia_product_id_foreign` (`product_id`),
  CONSTRAINT `product_multimedia_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.product_multimedia: ~0 rows (approximately)
/*!40000 ALTER TABLE `product_multimedia` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_multimedia` ENABLE KEYS */;

-- Dumping structure for table freeback.search_queries
CREATE TABLE IF NOT EXISTS `search_queries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `search_query` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `search_type` enum('combined','free_text') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.search_queries: ~0 rows (approximately)
/*!40000 ALTER TABLE `search_queries` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_queries` ENABLE KEYS */;

-- Dumping structure for table freeback.stores
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ae_code` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_category_id` int(10) unsigned NOT NULL,
  `discount_rate` double(8,2) NOT NULL DEFAULT '1.00',
  `freeback_rate` double(8,2) NOT NULL DEFAULT '30.00',
  `referral_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_referral_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permalink` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verify_code` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_type` enum('physical','online','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stores_email_unique` (`email`),
  UNIQUE KEY `stores_vat_number_unique` (`vat_number`),
  UNIQUE KEY `stores_permalink_unique` (`permalink`),
  UNIQUE KEY `stores_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.stores: ~0 rows (approximately)
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` (`id`, `email`, `password`, `business_name`, `vat_number`, `ae_code`, `store_category_id`, `discount_rate`, `freeback_rate`, `referral_code`, `own_referral_code`, `permalink`, `website`, `phone_number`, `active`, `email_verified`, `email_verify_code`, `store_type`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'store@fb.com', '$2y$10$JaUw1AWbxIJtaP440unzfuO4JzlVOJlvNMav.5HIw1mGCcnnpmcTC', 'Store', '34876874654', 'A-12345', 1, 1.00, 30.00, 'P-GETTER1', 'S-25704549', 'Store_-Cashback-WJNREudfoM', '', '3927656454', 1, 0, 'mNqOYVOMpIIrzoKcN4pPqPAOck4LVVjA20GtfCO7RO3ttcvcEA0gBNXdpMQLlIVBJjgUIuHSNO6628fakLlvYRJAaleYw8uQRWn62pd4TfYUZm6MaZsFBztNOzlUZ6pKoIidgFEFkPmZ', 'both', NULL, '2019-11-22 17:55:03', '2019-11-22 17:55:03');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

-- Dumping structure for table freeback.store_activities
CREATE TABLE IF NOT EXISTS `store_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `notification` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('administrative','order','scrapper','info') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_activities: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_activities` ENABLE KEYS */;

-- Dumping structure for table freeback.store_bank_infos
CREATE TABLE IF NOT EXISTS `store_bank_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entrance_iban` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_bank_infos_entrance_iban_unique` (`entrance_iban`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_bank_infos: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_bank_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_bank_infos` ENABLE KEYS */;

-- Dumping structure for table freeback.store_branches
CREATE TABLE IF NOT EXISTS `store_branches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `street_address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_branches_store_id_foreign` (`store_id`),
  CONSTRAINT `store_branches_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_branches: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_branches` DISABLE KEYS */;
INSERT INTO `store_branches` (`id`, `store_id`, `street_address`, `lat`, `lng`, `active`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Via di Roma, 22, 48121 Ravenna RA, Italia', 44.4125145, 12.206281600000011, 1, '2019-11-22 17:55:03', '2019-11-22 17:55:03');
/*!40000 ALTER TABLE `store_branches` ENABLE KEYS */;

-- Dumping structure for table freeback.store_categories
CREATE TABLE IF NOT EXISTS `store_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_categories: ~30 rows (approximately)
/*!40000 ALTER TABLE `store_categories` DISABLE KEYS */;
INSERT INTO `store_categories` (`id`, `name`, `slug`, `lang`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'Generic', 'generic', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(2, 'Abbigliamento', 'abbigliamento', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(3, 'Scarpe e Borse', 'scarpe-e-borse', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(4, 'Alimentari e Cura della Casa', 'alimentari-e-cura-della-casa', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(5, 'Arredamento', 'arredamento', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(6, 'Auto e Moto', 'auto-e-moto', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(7, 'Bellezza e Salute', 'bellezza-e-salute', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(8, 'Farmacia e Parafarmacia', 'farmacia-e-parafarmacia', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(9, 'Banca e Assicurazione', 'banca-e-assicurazione', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(10, 'Cancelleria e Ufficio', 'cancelleria-e-ufficio', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(11, 'Casa e Cucina', 'casa-e-cucina', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(12, 'Carburanti', 'carburanti', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(13, 'Energia e Gas', 'energia-e-gas', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(14, 'Animali', 'animali', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(15, 'Elettronica', 'elettronica', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(16, 'Grande Dist. Organizzata', 'grande-dist.-organizzata', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(17, 'Fai da Te', 'fai-da-te', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(18, 'Film e TV', 'film-e-tv', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(19, 'Giardinaggio', 'giardinaggio', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(20, 'Giochi e Giocattoli', 'giochi-e-giocattoli', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(21, 'Gioielli e Bigiotteria', 'gioielli-e-bigiotteria', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(22, 'Illuminazione', 'illuminazione', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(23, 'Informatica', 'informatica', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(24, 'Libri', 'libri', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(25, 'Ottica', 'ottica', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(26, 'Prima Infanzia', 'prima-infanzia', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(27, 'Servizi di Ristorazione', 'servizi-di-ristorazione', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(28, 'Strumenti Musicali', 'strumenti-musicali', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(29, 'Telefonia', 'telefonia', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22'),
	(30, 'Trasporti', 'trasporti', 'it', 1, '2019-11-22 17:16:22', '2019-11-22 17:16:22');
/*!40000 ALTER TABLE `store_categories` ENABLE KEYS */;

-- Dumping structure for table freeback.store_documents
CREATE TABLE IF NOT EXISTS `store_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('v_camerale','id','piva') COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_documents: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_documents` ENABLE KEYS */;

-- Dumping structure for table freeback.store_help_requests
CREATE TABLE IF NOT EXISTS `store_help_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `request` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answered` tinyint(1) NOT NULL DEFAULT '0',
  `answer` text COLLATE utf8mb4_unicode_ci,
  `admin_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_help_requests: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_help_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_help_requests` ENABLE KEYS */;

-- Dumping structure for table freeback.store_multimedia
CREATE TABLE IF NOT EXISTS `store_multimedia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `logo_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_image_thumbnail` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landing_background_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_thumb` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_multimedia_store_id_foreign` (`store_id`),
  CONSTRAINT `store_multimedia_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_multimedia: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_multimedia` DISABLE KEYS */;
INSERT INTO `store_multimedia` (`id`, `store_id`, `logo_url`, `front_image_thumbnail`, `landing_background_url`, `mobile_thumb`, `created_at`, `updated_at`) VALUES
	(1, 1, 'images/defaults/store.jpg', 'images/defaults/store_small.png', 'images/defaults/store_bg.jpg', NULL, '2019-11-22 17:55:03', '2019-11-22 17:55:03');
/*!40000 ALTER TABLE `store_multimedia` ENABLE KEYS */;

-- Dumping structure for table freeback.store_notifications
CREATE TABLE IF NOT EXISTS `store_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `type` enum('product_shipped','marketing','general_info') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general_info',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_notifications: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_notifications` ENABLE KEYS */;

-- Dumping structure for table freeback.store_payment_configs
CREATE TABLE IF NOT EXISTS `store_payment_configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `dp_connected` tinyint(1) NOT NULL DEFAULT '0',
  `dp_connection_id` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_connection_code` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp_pull_id` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_pull_granted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_payment_configs: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_payment_configs` DISABLE KEYS */;
INSERT INTO `store_payment_configs` (`id`, `store_id`, `dp_connected`, `dp_connection_id`, `dp_connection_code`, `dp_pull_id`, `dp_pull_granted`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'FAKE_CODE', NULL, 'FAKE_CODE', 1, '2019-11-22 17:55:03', '2019-11-22 17:55:03');
/*!40000 ALTER TABLE `store_payment_configs` ENABLE KEYS */;

-- Dumping structure for table freeback.store_referral_transactions
CREATE TABLE IF NOT EXISTS `store_referral_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `transaction_type` enum('online','offline','cash','tradedoubler') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `dp_push_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('completed','error','other','missing_payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'missing_payment',
  `import` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_referral_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_referral_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_referral_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.store_reviews
CREATE TABLE IF NOT EXISTS `store_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('positive','negative') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'positive',
  `signaled_by_store` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_reviews: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_reviews` ENABLE KEYS */;

-- Dumping structure for table freeback.store_visits
CREATE TABLE IF NOT EXISTS `store_visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.store_visits: ~0 rows (approximately)
/*!40000 ALTER TABLE `store_visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_visits` ENABLE KEYS */;

-- Dumping structure for table freeback.td_store_discounts
CREATE TABLE IF NOT EXISTS `td_store_discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cashback` double(8,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `t_d_store_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.td_store_discounts: ~0 rows (approximately)
/*!40000 ALTER TABLE `td_store_discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `td_store_discounts` ENABLE KEYS */;

-- Dumping structure for table freeback.trade_doubler_trackings
CREATE TABLE IF NOT EXISTS `trade_doubler_trackings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `site_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.trade_doubler_trackings: ~0 rows (approximately)
/*!40000 ALTER TABLE `trade_doubler_trackings` DISABLE KEYS */;
INSERT INTO `trade_doubler_trackings` (`id`, `subscription_id`, `user_id`, `program_id`, `site_id`, `created_at`, `updated_at`) VALUES
	(1, '5dd81b3ce4b0e9e5730e43f3', 1, 77460, 1, '2019-11-22 18:30:41', '2019-11-22 18:30:41'),
	(2, '5dd83a7ce4b0e9e5730e43f4', 1, 77460, 1, '2019-11-22 20:44:01', '2019-11-22 20:44:01');
/*!40000 ALTER TABLE `trade_doubler_trackings` ENABLE KEYS */;

-- Dumping structure for table freeback.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `store_branch_id` int(10) unsigned NOT NULL,
  `cash_desk_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `full_import` double(8,2) NOT NULL,
  `discount_rate` double(8,2) NOT NULL,
  `freeback_rate` double(8,2) NOT NULL,
  `cashback_neto` double(8,2) NOT NULL,
  `freeback_neto` double(8,2) NOT NULL,
  `status` enum('created','refused','error','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `dp_pull_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notified` tinyint(1) NOT NULL DEFAULT '0',
  `royalty_check` tinyint(1) NOT NULL DEFAULT '0',
  `invoiced` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.t_d_stores
CREATE TABLE IF NOT EXISTS `t_d_stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `store_description` text COLLATE utf8mb4_unicode_ci,
  `front_thumbnail` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_image` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_time` enum('day','week','month','3month') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'week',
  `credit_time` enum('day','week','month','3month') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'week',
  `cashback` double(8,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `slug` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `t_d_stores_program_id_unique` (`program_id`),
  UNIQUE KEY `t_d_stores_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.t_d_stores: ~0 rows (approximately)
/*!40000 ALTER TABLE `t_d_stores` DISABLE KEYS */;
INSERT INTO `t_d_stores` (`id`, `name`, `email`, `target_url`, `program_id`, `store_description`, `front_thumbnail`, `bg_image`, `logo`, `tracking_time`, `credit_time`, `cashback`, `active`, `slug`, `store_category_id`, `created_at`, `updated_at`) VALUES
	(1, 'td', 'eeee@ee.com', 'http://clkuk.tradedoubler.com/click?p=77460&a=3068510&g=23954948', 77460, 'df', 'uploads/images/tradedoubler/OVFE2f5zWuY0dJF.jpg', 'uploads/images/tradedoubler/cyOpFdEXN5gD8ah.jpg', 'uploads/images/tradedoubler\\lEzUr0fUnJTAMne.jpg', 'day', 'day', 9.00, 1, 'td-cashback-freeback-b9a3fIQH6Y', 1, '2019-11-22 18:29:39', '2019-11-22 18:29:39');
/*!40000 ALTER TABLE `t_d_stores` ENABLE KEYS */;

-- Dumping structure for table freeback.t_d_transactions
CREATE TABLE IF NOT EXISTS `t_d_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `t_d_store` int(10) unsigned NOT NULL,
  `full_import` double(8,2) NOT NULL,
  `discount_rate` double(8,2) NOT NULL,
  `freeback_rate` double(8,2) NOT NULL,
  `freeback_neto` double(8,2) NOT NULL,
  `cashback_neto` double(8,2) NOT NULL,
  `royalty_check` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_d_transactions_t_d_store_foreign` (`t_d_store`),
  KEY `t_d_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `t_d_transactions_t_d_store_foreign` FOREIGN KEY (`t_d_store`) REFERENCES `t_d_stores` (`id`),
  CONSTRAINT `t_d_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.t_d_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `t_d_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_d_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','missing_payment','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'missing_payment',
  `active_until` date NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `phone_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verify_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_verify_token` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referral_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_referral_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_no_unique` (`phone_no`),
  UNIQUE KEY `users_phone_verify_token_unique` (`phone_verify_token`),
  UNIQUE KEY `users_own_referral_code_unique` (`own_referral_code`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_no`, `status`, `active_until`, `city_id`, `email_verified`, `phone_verified`, `email_verify_token`, `phone_verify_token`, `referral_code`, `own_referral_code`, `api_token`, `avatar_url`, `newsletter`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Elhan Ibraimi', 'user@fb.com', '$2y$10$FOi0TfwKUfUgVjkhNo9ajObNlUr7ntWn5SUg6h6BN9n7f3JDeo1pC', '3874837431', 'missing_payment', '2020-11-22', 92, 0, 0, 'eJLqBRYtcq5c0N6gBJYDtL7R84HZzSTfdQulOurwcTbMGrQsZgzTcdJBk4U45WoRbCSAE4dy8uu9TUzEDRq0iEU5eUBp80zJ9fwz0mCDp04lnhT56Jw9evWr1fHXfKTD', '5600', 'P-GETTER1', 'U-49408427', 'dj2elFrgh3hhr5oUv4McIqNPhYCjvW6AsG8Hd3hu7AgRW0CsvvwnBxzMRslCmL8rP03OMnHWocv46eX6LeIy8OWaa99aA2XzYYBSYtzQhDKolAAidnx7yVDvoyc6UsMEisC6eTU5xioI1n5RovFDn2', 'images/defaults/user.jpg', 1, NULL, '2019-11-22 17:23:48', '2019-11-22 17:23:48'),
	(6, 'Elhan Ibraimi', 'use1r@fb.com', '$2y$10$FOi0TfwKUfUgVjkhNo9ajObNlUr7ntWn5SUg6h6BN9n7f3JDeo1pC', '38748317431', 'missing_payment', '2020-11-22', 92, 0, 0, 'eJLqBRYtcq5c0N6gBJYDtL7R84HZzSTfdQulOurwcTbMGrQsZgzTcdJBk4U45WoRbCSAE4dy8uu9TUzEDRq0iEU5eUBp80zJ9fwz0mCDp04lnhT56Jw9evWr1fHXfKTD', '56001', '', 'U-49408422', 'dj2elFrgh3hhr5oUv4McIqNPhYCjvW6AsG8Hd3hu7AgRW0CsvvwnBxzMRslCmL8rP03OMnHWocv46eX6LeIy8OWaa99aA2XzYYBSYtzQhDKolAAidnx7yVDvoyc6UsMEisC6U5xioI1n5RovFDn2', 'images/defaults/user.jpg', 1, NULL, '2019-11-22 17:23:48', '2019-11-22 17:23:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table freeback.user_addresses
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_notes` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_number` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_addresses_user_id_foreign` (`user_id`),
  KEY `user_addresses_country_id_foreign` (`country_id`),
  CONSTRAINT `user_addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_addresses: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_addresses` ENABLE KEYS */;

-- Dumping structure for table freeback.user_bank_infos
CREATE TABLE IF NOT EXISTS `user_bank_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `income_iban` varchar(34) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_bank_infos_income_iban_unique` (`income_iban`),
  KEY `user_bank_infos_user_id_foreign` (`user_id`),
  CONSTRAINT `user_bank_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_bank_infos: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_bank_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_bank_infos` ENABLE KEYS */;

-- Dumping structure for table freeback.user_favourites
CREATE TABLE IF NOT EXISTS `user_favourites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_favourites_product_id_foreign` (`product_id`),
  CONSTRAINT `user_favourites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_favourites: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_favourites` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_favourites` ENABLE KEYS */;

-- Dumping structure for table freeback.user_help_requests
CREATE TABLE IF NOT EXISTS `user_help_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `request` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answered` tinyint(1) NOT NULL DEFAULT '0',
  `answer` text COLLATE utf8mb4_unicode_ci,
  `admin_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_help_requests: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_help_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_help_requests` ENABLE KEYS */;

-- Dumping structure for table freeback.user_notifications
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `type` enum('product_shipped','marketing','general_info') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general_info',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_notifications: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notifications` ENABLE KEYS */;

-- Dumping structure for table freeback.user_payment_configs
CREATE TABLE IF NOT EXISTS `user_payment_configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `dp_connected` tinyint(1) NOT NULL DEFAULT '0',
  `dp_connection_id` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp_connection_code` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_payment_configs: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_payment_configs` DISABLE KEYS */;
INSERT INTO `user_payment_configs` (`id`, `user_id`, `dp_connected`, `dp_connection_id`, `dp_connection_code`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'pO7exZmYxOLRgSI4fUOuUJI2r14LLnXvemMYkGl1QEbnOKyVG2ygK2DnmRhZRO5V8QcfkAQLzoKODm1TgU9GAKSSkCyzoYKUbM13TU3HzR2RU3vVPoJ26REingDCbntMPA0Mu0fx8KdhdniiyUoDFn', '930BjSzrgDiny6sWqPE7XFz5Hguzb7UbR1Hwj9PkakqHH1hMOdoGCGZGpZ86psaw5NB7CRWTKSF16GQy1wZRLUs0Yp0KbweURPuqVNjhwHkp1aBZnPu9em8q3OrsnmkcUbF1MiZIb5YgcxWFcNLE0f', '2019-11-22 17:23:48', '2019-11-22 17:23:48');
/*!40000 ALTER TABLE `user_payment_configs` ENABLE KEYS */;

-- Dumping structure for table freeback.user_referral_transactions
CREATE TABLE IF NOT EXISTS `user_referral_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `invited_user` int(10) unsigned NOT NULL,
  `dp_push_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import` double(8,2) NOT NULL,
  `status` enum('completed','error','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_referral_transactions: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_referral_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_referral_transactions` ENABLE KEYS */;

-- Dumping structure for table freeback.user_subscriptions
CREATE TABLE IF NOT EXISTS `user_subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `import` double(8,2) NOT NULL,
  `pay_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_until` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_subscriptions: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_subscriptions` ENABLE KEYS */;

-- Dumping structure for table freeback.user_wallets
CREATE TABLE IF NOT EXISTS `user_wallets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `account_balance` double(8,2) NOT NULL DEFAULT '0.00',
  `available_balance` double(8,2) NOT NULL DEFAULT '0.00',
  `friends_balance` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `user_wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table freeback.user_wallets: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_wallets` DISABLE KEYS */;
INSERT INTO `user_wallets` (`id`, `user_id`, `account_balance`, `available_balance`, `friends_balance`, `created_at`, `updated_at`) VALUES
	(1, 1, 0.00, 0.00, 0.00, '2019-11-22 17:23:48', '2019-11-22 17:23:48');
/*!40000 ALTER TABLE `user_wallets` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
