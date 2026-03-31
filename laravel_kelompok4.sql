-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 31, 2026 at 02:32 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `latitude_pulang` decimal(10,8) DEFAULT NULL,
  `longitude_pulang` decimal(11,8) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('tepat_waktu','terlambat','alpha','izin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tepat_waktu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lembur_menit` int DEFAULT NULL,
  `selisih_pulang_cepat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `uuid`, `guru_id`, `latitude`, `longitude`, `latitude_pulang`, `longitude_pulang`, `photo`, `photo_pulang`, `status`, `created_at`, `updated_at`, `tanggal`, `status_pulang`, `lembur_menit`, `selisih_pulang_cepat`) VALUES
(46, 'f861e965-a761-4bc6-9646-a2e55da8f746', 25, -6.72372644, 108.55322970, -6.72372577, 108.55323459, 'absensi/271f810c-d2c8-413e-9e9e-8705a5099161.png', 'absensi/c446b0c8-4924-493c-bc46-6f76795dd709.png', 'tepat_waktu', '2026-03-31 11:44:22', '2026-03-31 11:44:34', NULL, 'pulang_cepat', 0, 5),
(47, '4280ec49-3362-42cf-9ef7-27ba4725159a', 28, -6.72380226, 108.55322525, -6.72373336, 108.55339056, 'absensi/2d5c33b3-1c43-4082-a01d-8dd2195c2e12.png', 'absensi/f06f990a-086d-474e-a1fa-216d867b853e.png', 'terlambat', '2026-03-31 12:00:17', '2026-03-31 12:03:56', NULL, 'lembur', 124, 0),
(48, '165b8bef-3dbb-40df-92e7-579a9bd1736d', 29, NULL, NULL, NULL, NULL, NULL, NULL, 'alpha', '2026-03-31 12:13:09', '2026-03-31 12:13:09', NULL, NULL, NULL, NULL),
(49, '6518bbd8-a8b6-4b81-8d9f-f2942a4af148', 30, -6.72391276, 108.55320734, -6.72381433, 108.55322401, 'absensi/0d1c66d3-c9a3-4d16-9f7b-5ddfec33b77e.png', 'absensi/597bc417-f66c-40a6-b1e1-c299f615c982.png', 'tepat_waktu', '2026-03-31 12:14:46', '2026-03-31 12:16:34', NULL, 'tepat_waktu', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_guru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `mapel_id` bigint UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `uuid`, `nama_guru`, `email`, `nip`, `password`, `nomor_telepon`, `photo`, `is_active`, `created_at`, `updated_at`, `role`, `mapel_id`, `remember_token`) VALUES
(25, 'fccdccbb-6d14-4289-9c1a-091fc8bad6cb', 'Safirah Almira', 'ssafiraalmira@gmail.com', '123456789101121317', '$2y$12$t2YEUIMTRDCy1lo8JFRF4.X5Jp/5EuMmjYkGMmwkadrH9vpCd6kja', '0882000768044', 'guru/JQvmUtABcK0hsJ3cn5t5dDcKD1G70JFswnwrVYSD.jpg', 1, '2026-03-31 11:31:41', '2026-03-31 11:43:41', 'guru', 1, NULL),
(28, '980092fe-7289-4654-af87-dc34d67ac946', 'Aurelia Prasetya Sari', 'aureliasari@gmail.com', '123456789101121114', '$2y$12$8/uz8J3nGQo45JJck4AKTeDFWS6bDIjNEf4VD5flQxhg98aTrC/P2', '0882000712983', NULL, 1, '2026-03-31 11:54:06', '2026-03-31 11:54:06', 'guru', 2, NULL),
(29, '2b6fc866-695c-4e85-a084-ef6c194a9f8c', 'test', 'test@gmail.com', '123456789101121112', '$2y$12$XPXIymyyzMyWtco89gqqPen3zKVXSHZ8Kn2OY6cHKwwiFKLcgZLtK', '0889246732864', NULL, 1, '2026-03-31 12:07:26', '2026-03-31 12:07:26', 'guru', 3, NULL),
(30, '5d293040-b2cd-4d34-b53b-8e3b58f6f9ff', 'test2', 'test2@gmail.com', '123456789101121117', '$2y$12$D.a8h.A0LAVFn1/E3igHDugKfZas7VyLHiG89YiD1.M5Q9c/qmioe', '0889246732864', NULL, 1, '2026-03-31 12:13:52', '2026-03-31 12:13:52', 'guru', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hari_liburs`
--

CREATE TABLE `hari_liburs` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izins`
--

CREATE TABLE `izins` (
  `id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `jenis_izin` enum('sakit','izin','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci,
  `foto_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_izin` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kehadirans`
--

CREATE TABLE `kehadirans` (
  `id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `lembur_menit` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jam_mulai_masuk` time DEFAULT NULL,
  `jam_mulai_pulang` time DEFAULT NULL,
  `jam_akhir_pulang` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kehadirans`
--

INSERT INTO `kehadirans` (`id`, `guru_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `lembur_menit`, `created_at`, `updated_at`, `jam_mulai_masuk`, `jam_mulai_pulang`, `jam_akhir_pulang`) VALUES
(39, 25, '2026-03-31', '18:44:22', '18:44:34', 0, '2026-03-31 11:44:22', '2026-03-31 11:44:34', NULL, NULL, NULL),
(40, 28, '2026-03-31', '19:00:17', '19:03:56', 124, '2026-03-31 12:00:17', '2026-03-31 12:03:56', NULL, NULL, NULL),
(41, 29, '2026-03-31', NULL, NULL, 0, '2026-03-31 12:13:09', '2026-03-31 12:13:09', NULL, NULL, NULL),
(42, 30, '2026-03-31', '19:14:46', '19:16:34', 0, '2026-03-31 12:14:46', '2026-03-31 12:16:34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mapels`
--

CREATE TABLE `mapels` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_mapel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapels`
--

INSERT INTO `mapels` (`id`, `nama_mapel`, `created_at`, `updated_at`) VALUES
(1, 'Bahasa Inggris', NULL, NULL),
(2, 'Bahasa Indonesia', NULL, NULL),
(3, 'PAI', NULL, NULL),
(4, 'Matematika', NULL, NULL),
(5, 'IPS', NULL, NULL),
(6, 'IPA', NULL, NULL),
(7, 'TIK', NULL, NULL),
(8, 'Seni Budaya', NULL, NULL),
(9, 'Bahasa Arab', NULL, NULL),
(10, 'Bahasa Cirebon', NULL, NULL),
(11, 'PJOK', NULL, NULL),
(12, 'PKN', NULL, NULL),
(13, 'BTQ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_02_153601_create_permission_tables', 1),
(6, '2026_02_03_030042_create_gurus_table', 2),
(7, '2026_02_06_004635_create_absensis_table', 3),
(8, '2026_02_06_033534_add_user_id_to_gurus_table', 4),
(9, '2026_02_08_124614_add_user_id_to_gurus_table', 4),
(10, '2026_02_09_023232_add_password_to_gurus_table', 5),
(11, '2026_02_09_025519_add_role_to_gurus_table', 6),
(12, '2026_02_09_032822_add_nip_to_users_table', 7),
(13, '2026_02_15_024920_create_mapels_table', 8),
(14, '2026_02_15_024943_add_mapel_id_to_gurus_table', 9),
(16, '2026_02_15_030743_drop_mata_pelajaran_from_gurus_table', 10),
(17, '2026_02_15_032122_add_email_to_gurus_table', 11),
(18, '2026_02_15_140046_add_remember_token_to_gurus_table', 12),
(19, '2026_02_10_040935_add_is_active_to_users_table', 13),
(20, '2026_02_11_063737_create_izins_table', 14),
(21, '2026_02_11_141016_create_perizinans_table', 14),
(22, '2026_02_10_070305_add_deleted_at_to_izins_table', 15),
(23, '2026_02_10_055924_add_nip_to_users_table', 16),
(24, '2026_03_18_183254_create_kehadirans_table', 17),
(25, '2026_03_18_185144_add_pulang_columns_to_absensis_table', 18),
(26, '2026_03_18_190334_add_photo_status_to_absensis_table', 19),
(27, '2026_03_18_191239_fix_absensis_table', 20),
(28, '2026_03_19_233818_fix_status_enum_on_absensis_table', 21),
(29, '2026_03_19_234512_fix_nullable_columns_on_absensis_table', 22),
(30, '2026_03_19_234528_cleanup_absensis_table', 22),
(31, '2026_03_20_005109_remove_deleted_at_from_users_and_gurus_table', 23),
(32, '2026_02_10_073008_create_waktus_table', 24),
(33, '2026_03_28_124754_fix_waktus_table', 25),
(34, '2026_03_28_125325_create_hari_liburs_table', 26),
(35, '2026_03_28_130123_create_waktus_table', 26),
(36, '2026_03_28_130838_fix_waktus_table', 27),
(37, '2026_03_28_131650_add_hari_libur_to_waktus_table', 28),
(38, '2026_03_28_143125_add_waktu_to_kehadirans_table', 29),
(39, '2026_03_28_145219_add_status_pulang_to_absensis_table', 29),
(40, '2026_03_28_153533_add_selisih_pulang_cepat_to_absensis_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 9);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2026-02-03 06:40:39', '2026-02-03 06:40:39'),
(2, 'admin', 'web', '2026-02-03 06:40:39', '2026-02-03 06:40:39'),
(3, 'user', 'web', '2026-02-05 18:01:30', '2026-02-05 18:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('d0mATwTzCn2wXQpcgtMv2EtmQeJcriFb3z68Gr7Z', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzA4czBYVFhZeWo1MnRQd25UUE5WQmY2dGZpaVNpMlI2WHhva2dqSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9rZWhhZGlyYW4vY2V0YWs/YnVsYW49MyZ0YWI9cHVsYW5nJnRhaHVuPTIwMjYiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmtlaGFkaXJhbi5jZXRhayI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774967244);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `nip`, `password`, `remember_token`, `role`, `photo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '351f2ade-85cd-4f00-8fa5-58ff80091d0e', 'Sofi', 'sofi', '12345678910', '$2y$12$B14GYvRnxf6ponQ7qECoee4asauxGyJILCzUG3znnAsf.7ISPcv42', '3TNs6s8ZDvj82I409Klz24zyu1M7v6dubY8HBDpM8JLTUtcB19tdBDusOnmy', 'superadmin', NULL, 1, '2026-02-03 06:40:40', '2026-03-19 17:17:33'),
(9, '59022033-edb1-404c-9a4a-fd4843ef62f7', 'Kepala Sekolah', 'kepsek', NULL, '$2y$12$VAeeF3mHLBNJG1vLZx6zlu/AglqoJcvUf8ZDCwxJb1bONIbbw78hu', NULL, 'admin', NULL, 1, '2026-03-19 17:43:07', '2026-03-29 11:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `waktus`
--

CREATE TABLE `waktus` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mulai_tap_in` time NOT NULL DEFAULT '06:00:00',
  `akhir_tap_in` time NOT NULL DEFAULT '09:00:00',
  `batas_terlambat` time NOT NULL DEFAULT '07:00:00',
  `mulai_tap_out` time NOT NULL DEFAULT '13:00:00',
  `akhir_tap_out` time NOT NULL DEFAULT '15:00:00',
  `hari_libur_mingguan` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waktus`
--

INSERT INTO `waktus` (`id`, `created_at`, `updated_at`, `mulai_tap_in`, `akhir_tap_in`, `batas_terlambat`, `mulai_tap_out`, `akhir_tap_out`, `hari_libur_mingguan`) VALUES
(1, '2026-03-28 06:17:40', '2026-03-31 12:14:29', '07:00:00', '19:16:00', '19:15:00', '19:16:00', '19:17:00', '[\"Sabtu\", \"Minggu\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensis_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_nip_unique` (`nip`),
  ADD UNIQUE KEY `gurus_uuid_unique` (`uuid`),
  ADD KEY `gurus_is_active_index` (`is_active`),
  ADD KEY `gurus_mapel_id_foreign` (`mapel_id`);

--
-- Indexes for table `hari_liburs`
--
ALTER TABLE `hari_liburs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hari_liburs_tanggal_unique` (`tanggal`);

--
-- Indexes for table `izins`
--
ALTER TABLE `izins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `izins_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kehadirans_guru_id_tanggal_unique` (`guru_id`,`tanggal`);

--
-- Indexes for table `mapels`
--
ALTER TABLE `mapels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD KEY `users_is_active_index` (`is_active`);

--
-- Indexes for table `waktus`
--
ALTER TABLE `waktus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `hari_liburs`
--
ALTER TABLE `hari_liburs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `izins`
--
ALTER TABLE `izins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kehadirans`
--
ALTER TABLE `kehadirans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `mapels`
--
ALTER TABLE `mapels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `waktus`
--
ALTER TABLE `waktus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `izins`
--
ALTER TABLE `izins`
  ADD CONSTRAINT `izins_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD CONSTRAINT `kehadirans_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
