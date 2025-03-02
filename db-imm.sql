-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.39 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for imm_report
CREATE DATABASE IF NOT EXISTS `imm_report` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `imm_report`;

-- Dumping structure for table imm_report.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.cache: ~5 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('056fc329aaaa757d31db450f525da23fde4d1b36', 'i:2;', 1740899003),
	('056fc329aaaa757d31db450f525da23fde4d1b36:timer', 'i:1740899003;', 1740899003),
	('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1740847143),
	('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1740847143;', 1740847143),
	('77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:2;', 1740892784),
	('77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1740892784;', 1740892784),
	('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1740899071),
	('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1740899071;', 1740899071),
	('spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:49:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:13:"View Any User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:9:"View User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:11:"Create User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:11:"Update User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:11:"Delete User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:12:"Restore User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:17:"Force Delete User";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:7;a:4:{s:1:"a";i:8;s:1:"b";s:13:"View Any Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:8;a:4:{s:1:"a";i:9;s:1:"b";s:9:"View Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:9;a:4:{s:1:"a";i:10;s:1:"b";s:11:"Create Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:10;a:4:{s:1:"a";i:11;s:1:"b";s:11:"Update Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:11;a:4:{s:1:"a";i:12;s:1:"b";s:11:"Delete Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:12;a:4:{s:1:"a";i:13;s:1:"b";s:12:"Restore Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:13;a:4:{s:1:"a";i:14;s:1:"b";s:17:"Force Delete Role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:14;a:4:{s:1:"a";i:15;s:1:"b";s:19:"View Any Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:15;a:4:{s:1:"a";i:16;s:1:"b";s:15:"View Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:16;a:4:{s:1:"a";i:17;s:1:"b";s:17:"Create Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:17;a:4:{s:1:"a";i:18;s:1:"b";s:17:"Update Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:18;a:4:{s:1:"a";i:19;s:1:"b";s:17:"Delete Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:19;a:4:{s:1:"a";i:20;s:1:"b";s:18:"Restore Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:20;a:4:{s:1:"a";i:21;s:1:"b";s:23:"Force Delete Permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:21;a:4:{s:1:"a";i:22;s:1:"b";s:16:"View Any Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:22;a:4:{s:1:"a";i:23;s:1:"b";s:12:"View Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:23;a:4:{s:1:"a";i:24;s:1:"b";s:14:"Create Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:24;a:4:{s:1:"a";i:25;s:1:"b";s:14:"Update Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:25;a:4:{s:1:"a";i:26;s:1:"b";s:14:"Delete Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:26;a:4:{s:1:"a";i:27;s:1:"b";s:15:"Restore Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:27;a:4:{s:1:"a";i:28;s:1:"b";s:20:"Force Delete Company";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:28;a:4:{s:1:"a";i:29;s:1:"b";s:16:"View Any Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:29;a:4:{s:1:"a";i:30;s:1:"b";s:12:"View Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:30;a:4:{s:1:"a";i:31;s:1:"b";s:14:"Create Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:31;a:4:{s:1:"a";i:32;s:1:"b";s:14:"Update Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:32;a:4:{s:1:"a";i:33;s:1:"b";s:14:"Delete Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:33;a:4:{s:1:"a";i:34;s:1:"b";s:15:"Restore Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:34;a:4:{s:1:"a";i:35;s:1:"b";s:20:"Force Delete Project";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:35;a:4:{s:1:"a";i:36;s:1:"b";s:15:"View Any Report";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:36;a:4:{s:1:"a";i:37;s:1:"b";s:11:"View Report";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:4:{s:1:"a";i:38;s:1:"b";s:13:"Create Report";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:38;a:4:{s:1:"a";i:39;s:1:"b";s:13:"Update Report";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:4:{s:1:"a";i:40;s:1:"b";s:13:"Delete Report";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:40;a:4:{s:1:"a";i:41;s:1:"b";s:14:"Restore Report";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:41;a:4:{s:1:"a";i:42;s:1:"b";s:19:"Force Delete Report";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:42;a:4:{s:1:"a";i:43;s:1:"b";s:17:"View Any Progress";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:43;a:4:{s:1:"a";i:44;s:1:"b";s:13:"View Progress";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:"a";i:45;s:1:"b";s:15:"Create Progress";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:45;a:4:{s:1:"a";i:46;s:1:"b";s:15:"Update Progress";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:46;a:4:{s:1:"a";i:47;s:1:"b";s:15:"Delete Progress";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:47;a:4:{s:1:"a";i:48;s:1:"b";s:16:"Restore Progress";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:48;a:4:{s:1:"a";i:49;s:1:"b";s:21:"Force Delete Progress";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}}s:5:"roles";a:2:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:13:"Administrator";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:10:"Kontraktor";s:1:"c";s:3:"web";}}}', 1740939641);

-- Dumping structure for table imm_report.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.cache_locks: ~0 rows (approximately)

-- Dumping structure for table imm_report.companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.companies: ~1 rows (approximately)
INSERT INTO `companies` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'PT. Indominco Mandiri', '2025-03-01 13:02:59', '2025-03-01 13:02:59');

-- Dumping structure for table imm_report.exports
CREATE TABLE IF NOT EXISTS `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.exports: ~0 rows (approximately)

-- Dumping structure for table imm_report.failed_import_rows
CREATE TABLE IF NOT EXISTS `failed_import_rows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` bigint unsigned NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.failed_import_rows: ~0 rows (approximately)

-- Dumping structure for table imm_report.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table imm_report.imports
CREATE TABLE IF NOT EXISTS `imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.imports: ~0 rows (approximately)

-- Dumping structure for table imm_report.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.jobs: ~0 rows (approximately)

-- Dumping structure for table imm_report.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.job_batches: ~0 rows (approximately)

-- Dumping structure for table imm_report.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_12_11_003633_create_permission_tables', 1),
	(5, '2024_12_27_215542_create_notifications_table', 1),
	(6, '2024_12_27_215557_create_imports_table', 1),
	(7, '2024_12_27_215558_create_exports_table', 1),
	(8, '2024_12_27_215559_create_failed_import_rows_table', 1),
	(9, '2025_03_01_193148_create_companies_table', 1),
	(10, '2025_03_01_193150_create_user_companies_table', 1),
	(11, '2025_03_01_193151_create_projects_table', 1),
	(12, '2025_03_01_193152_create_reports_table', 1),
	(13, '2025_03_01_193153_create_report_edit_requests_table', 1),
	(14, '2025_03_01_193155_create_progress_realtimes_table', 1);

-- Dumping structure for table imm_report.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` tinyint unsigned NOT NULL,
  `model_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table imm_report.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` tinyint unsigned NOT NULL,
  `model_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.model_has_roles: ~2 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(2, 'App\\Models\\User', 3);

-- Dumping structure for table imm_report.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.notifications: ~0 rows (approximately)
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('0b982865-46e5-44fe-a5a9-1dfcaf17ea95', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 1, '{"actions":[{"name":"view","color":null,"event":null,"eventData":[],"dispatchDirection":false,"dispatchToComponent":null,"extraAttributes":[],"icon":null,"iconPosition":"before","iconSize":null,"isOutlined":false,"isDisabled":false,"label":"Lihat","shouldClose":false,"shouldMarkAsRead":false,"shouldMarkAsUnread":false,"shouldOpenUrlInNewTab":false,"size":"sm","tooltip":null,"url":"http:\\/\\/127.0.0.1:8000\\/laporan\\/19\\/edit","view":"filament-actions::link-action"}],"body":"Laporan \\"Test judul aplikasi\\" telah dibuat oleh User.","color":null,"duration":"persistent","icon":"heroicon-o-information-circle","iconColor":"info","status":"info","title":"Laporan Baru","view":"filament-notifications::notification","viewData":[],"format":"filament"}', NULL, '2025-03-02 07:03:37', '2025-03-02 07:03:37'),
	('37856305-4d59-4d7a-bc47-45c31979d7ff', 'Filament\\Notifications\\DatabaseNotification', 'App\\Models\\User', 2, '{"actions":[{"name":"edit","color":null,"event":null,"eventData":[],"dispatchDirection":false,"dispatchToComponent":null,"extraAttributes":[],"icon":null,"iconPosition":"before","iconSize":null,"isOutlined":false,"isDisabled":false,"label":"Ubah Laporan","shouldClose":false,"shouldMarkAsRead":false,"shouldMarkAsUnread":false,"shouldOpenUrlInNewTab":false,"size":"sm","tooltip":null,"url":"http:\\/\\/127.0.0.1:8000\\/laporan\\/19\\/edit","view":"filament-actions::link-action"}],"body":"Laporan Test judul aplikasi telah diperbarui statusnya menjadi Diterima .","color":null,"duration":"persistent","icon":"heroicon-o-check-circle","iconColor":"success","status":"success","title":"Status Laporan Diperbarui","view":"filament-notifications::notification","viewData":[],"format":"filament"}', NULL, '2025-03-02 07:04:13', '2025-03-02 07:04:13');

-- Dumping structure for table imm_report.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table imm_report.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.permissions: ~28 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'View Any User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(2, 'View User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(3, 'Create User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(4, 'Update User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(5, 'Delete User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(6, 'Restore User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(7, 'Force Delete User', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(8, 'View Any Role', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(9, 'View Role', 'web', '2025-03-01 12:24:01', '2025-03-01 12:24:01'),
	(10, 'Create Role', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(11, 'Update Role', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(12, 'Delete Role', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(13, 'Restore Role', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(14, 'Force Delete Role', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(15, 'View Any Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(16, 'View Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(17, 'Create Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(18, 'Update Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(19, 'Delete Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(20, 'Restore Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(21, 'Force Delete Permission', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(22, 'View Any Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:12:55'),
	(23, 'View Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:13:23'),
	(24, 'Create Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:13:34'),
	(25, 'Update Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:14:28'),
	(26, 'Delete Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:14:36'),
	(27, 'Restore Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:14:44'),
	(28, 'Force Delete Company', 'web', '2025-03-01 12:24:02', '2025-03-01 18:14:53'),
	(29, 'View Any Project', 'web', '2025-03-01 18:15:29', '2025-03-01 18:15:29'),
	(30, 'View Project', 'web', '2025-03-01 18:17:25', '2025-03-01 18:17:25'),
	(31, 'Create Project', 'web', '2025-03-01 18:17:32', '2025-03-01 18:17:32'),
	(32, 'Update Project', 'web', '2025-03-01 18:17:40', '2025-03-01 18:17:40'),
	(33, 'Delete Project', 'web', '2025-03-01 18:17:45', '2025-03-01 18:17:45'),
	(34, 'Restore Project', 'web', '2025-03-01 18:17:50', '2025-03-01 18:17:50'),
	(35, 'Force Delete Project', 'web', '2025-03-01 18:17:57', '2025-03-01 18:17:57'),
	(36, 'View Any Report', 'web', '2025-03-01 18:18:10', '2025-03-01 18:18:10'),
	(37, 'View Report', 'web', '2025-03-01 18:18:22', '2025-03-01 18:18:22'),
	(38, 'Create Report', 'web', '2025-03-01 18:18:28', '2025-03-01 18:18:28'),
	(39, 'Update Report', 'web', '2025-03-01 18:18:35', '2025-03-01 18:18:35'),
	(40, 'Delete Report', 'web', '2025-03-01 18:18:39', '2025-03-01 18:18:39'),
	(41, 'Restore Report', 'web', '2025-03-01 18:18:43', '2025-03-01 18:18:43'),
	(42, 'Force Delete Report', 'web', '2025-03-01 18:18:49', '2025-03-01 18:18:49'),
	(43, 'View Any Progress', 'web', '2025-03-01 18:19:14', '2025-03-01 18:19:14'),
	(44, 'View Progress', 'web', '2025-03-01 18:19:19', '2025-03-01 18:19:19'),
	(45, 'Create Progress', 'web', '2025-03-01 18:19:23', '2025-03-01 18:19:23'),
	(46, 'Update Progress', 'web', '2025-03-01 18:19:27', '2025-03-01 18:19:27'),
	(47, 'Delete Progress', 'web', '2025-03-01 18:19:32', '2025-03-01 18:19:32'),
	(48, 'Restore Progress', 'web', '2025-03-01 18:19:40', '2025-03-01 18:19:40'),
	(49, 'Force Delete Progress', 'web', '2025-03-01 18:19:48', '2025-03-01 18:19:48');

-- Dumping structure for table imm_report.progress_realtimes
CREATE TABLE IF NOT EXISTS `progress_realtimes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `progress` tinyint unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `progress_realtimes_project_id_foreign` (`project_id`),
  KEY `progress_realtimes_user_id_foreign` (`user_id`),
  CONSTRAINT `progress_realtimes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progress_realtimes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.progress_realtimes: ~0 rows (approximately)

-- Dumping structure for table imm_report.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.projects: ~1 rows (approximately)
INSERT INTO `projects` (`id`, `name`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
	(1, 'Proyek Tambang', '2025-03-01', '2025-03-31', '2025-03-01 13:18:50', '2025-03-01 13:18:50');

-- Dumping structure for table imm_report.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `file_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_project_id_foreign` (`project_id`),
  KEY `reports_user_id_foreign` (`user_id`),
  CONSTRAINT `reports_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.reports: ~0 rows (approximately)
INSERT INTO `reports` (`id`, `project_id`, `user_id`, `title`, `description`, `status`, `file_path`, `created_at`, `updated_at`) VALUES
	(19, 1, 2, 'Test judul aplikasi', 'Test judul aplikasi', 1, 'laporan/User - Outfit.zip', '2025-03-02 07:03:34', '2025-03-02 07:04:13');

-- Dumping structure for table imm_report.report_edit_requests
CREATE TABLE IF NOT EXISTS `report_edit_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_edit_requests_report_id_foreign` (`report_id`),
  KEY `report_edit_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `report_edit_requests_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_edit_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.report_edit_requests: ~0 rows (approximately)

-- Dumping structure for table imm_report.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'web', '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(2, 'Kontraktor', 'web', '2025-03-01 12:24:02', '2025-03-01 18:16:02');

-- Dumping structure for table imm_report.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` tinyint unsigned NOT NULL,
  `role_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.role_has_permissions: ~28 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(37, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(36, 2),
	(37, 2),
	(38, 2),
	(39, 2),
	(43, 2),
	(44, 2),
	(45, 2),
	(46, 2);

-- Dumping structure for table imm_report.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('4O7uX78P6uVwTN0hK4v1o3XI5T2BEy4jpo877PEM', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoicjF1ZnlsRWFWYkJoNHdRNzhrbGpDQWtoYkFDUjZDdnA3dmRBbGJySCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbGFwb3JhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiQ3NWQ0dkJQSU13YVE4OWxaZVdad2tPMXQ5UHpGTVNWSmMyUXAveS9Hd2hIOGUwR1dPNlJkUyI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1740899837),
	('B9yREjSOc5LD4bb281abrtgagSpI1IvKSeVYsVRK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiQ1RDaFFUUTVrbURhamd6SG9RZ1VDVHRwNzVXRmVQNHl3aFFITHZtUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5nZ3VuYS8xL2VkaXQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkNjF2Vm81LjFxLnhCU1dTVnJya3k4ZUVBT2lUbnFrVUQ0WGpxUU9NMzYxS3pzc0J1YS4uaEsiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6MzA6ImZpbGFtZW50X3JlY29yZF9uYXZpZ2F0aW9uX2lkcyI7YTozOntpOjA7aToxO2k6MTtpOjI7aToyO2k6Mzt9fQ==', 1740899815),
	('EWF60Ro8UgIxUoEZCXiEseMM7YKksiQNw1DFICTJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMmFiWVFvUkM4b0NXZ0hqWDJzVkhZM2R5aTJ2RG9VWFdLZXhMUnRYZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1740898471),
	('qASRPBE34hpky9OaaatMxUAekCS1QYfWXzuyeLfj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWJWODdUdE0wWkFLbVBqUldhdU9SVllIaTdweGtXMzk5WkI2aXNQciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6OTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sYXBvcmFuP3RhYmxlRmlsdGVycyU1QnJlcG9ydEVkaXRSZXF1ZXN0cyU1RCU1QnN0YXR1cyU1RCU1QnZhbHVlJTVEPTAiO319', 1740898475),
	('ssDaBJieuS9j7ZjUMhHiaApR432fOE31VzlG6J0l', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSkpHWDg4SUxiTVlHVzdOWFI2T0pQbFVmc2JQcGlFWktRbTF1U2lVcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1740892561),
	('WOJRoPDjeFeXMIHNvkg1cxw4ZOQEpmMG3KbH5Ydk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiRlY5R2JSUDZmN21pRXRyNzB3QWtjQjNyRTZaV1BKdXlUVDRWRjVTZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkNjF2Vm81LjFxLnhCU1dTVnJya3k4ZUVBT2lUbnFrVUQ0WGpxUU9NMzYxS3pzc0J1YS4uaEsiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoidGFibGVzIjthOjE6e3M6Mjc6Ikxpc3RSZXBvcnRzX3RvZ2dsZWRfY29sdW1ucyI7YToyOntzOjE4OiJyZXBvcnRFZGl0UmVxdWVzdHMiO2E6MTp7czo2OiJzdGF0dXMiO2I6MDt9czo5OiJmaWxlX3BhdGgiO2I6MDt9fXM6MzA6ImZpbGFtZW50X3JlY29yZF9uYXZpZ2F0aW9uX2lkcyI7YToyOntpOjA7aToxO2k6MTtpOjI7fX0=', 1740898647),
	('XZqOyPBwJ2btJBuAsiMiHslR0i9n2hw4rmFbwLPV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUVZRXlvajJuUzRvQ0tqTlNmUDZpVG5WU2lDc0g1SW9jRWxGbEYxSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1740898483);

-- Dumping structure for table imm_report.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar_url`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'admin@starter.com', NULL, '$2y$12$61vVo5.1q.xBSWSVrrky8eEAOiTnqkUD4XjqQOM361KzssBua..hK', NULL, 0, NULL, '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(2, 'User', 'user@starter.com', NULL, '$2y$12$75d4vBPIMwaQ89lZeWZwkO1t9PzFMSVJc2Qp/y/GwhH8e0GWO6RdS', NULL, 0, NULL, '2025-03-01 12:24:02', '2025-03-01 12:24:02'),
	(3, 'user 2', 'user2@starter.com', NULL, '$2y$12$CL8E7z8EcAkcMeqlrQ1x6e2UusUSzfCbykk3vwASG1EFxXZrUlAWW', NULL, 0, NULL, '2025-03-01 17:56:08', '2025-03-01 17:56:08');

-- Dumping structure for table imm_report.user_companies
CREATE TABLE IF NOT EXISTS `user_companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_companies_user_id_foreign` (`user_id`),
  KEY `user_companies_company_id_foreign` (`company_id`),
  CONSTRAINT `user_companies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table imm_report.user_companies: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
