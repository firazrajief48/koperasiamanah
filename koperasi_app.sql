-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 05:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_21_015616_add_role_to_users_table', 1),
(5, '2025_10_21_020852_add_additional_fields_to_users_table', 1),
(6, '2025_10_22_020253_create_pengurus_koperasis_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengurus_koperasis`
--

CREATE TABLE `pengurus_koperasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengurus_koperasis`
--

INSERT INTO `pengurus_koperasis` (`id`, `nama`, `jabatan`, `deskripsi`, `foto`, `email`, `telepon`, `urutan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Arrief Chandra Setiawan, S.ST, M.Si.', 'Kepala BPS', 'Memimpin dengan visi yang jelas dan dedikasi tinggi untuk kemajuan koperasi', NULL, 'ahmad.rizki@bps.go.id', '081234567890', 1, 1, '2025-10-21 19:03:56', '2025-10-21 19:03:56'),
(2, 'Nurcholis, S.Si.', 'Ketua Koperasi', 'Memimpin koperasi dengan integritas dan komitmen untuk kesejahteraan anggota', NULL, 'budi.santoso@koperasi.com', '081234567891', 2, 1, '2025-10-21 19:03:56', '2025-10-21 19:03:56'),
(3, 'Fadjar Suhaeri, SE, M.SE.', 'Wakil Ketua Koperasi', 'Mendukung kepemimpinan dengan pengalaman dan dedikasi yang tinggi', NULL, 'siti.nurhaliza@koperasi.com', '081234567892', 3, 1, '2025-10-21 19:03:56', '2025-10-21 19:03:56'),
(6, 'Fitri Kusumowardhani, SST', 'Bendahara Koperasi 2', 'Mendukung pengelolaan keuangan dengan keahlian akuntansi yang mumpuni', NULL, 'citra.dewi@koperasi.com', '081234567895', 6, 1, '2025-10-21 19:03:56', '2025-10-21 19:03:56'),
(12, 'Iir Lismawati, S.Si.', 'Sekretaris Koperasi', 'Mengorganisir administrasi dengan profesional dan teliti', NULL, 'rina.pratiwi@koperasi.com', '081234567893', 4, 1, '2025-10-21 19:20:29', '2025-10-21 19:20:29'),
(13, 'Retno Larasati, S.M.', 'Bendahara Koperasi 1', 'Mengelola keuangan dengan transparansi dan akuntabilitas tinggi', NULL, 'dedi.kurniawan@koperasi.com', '081234567894', 5, 1, '2025-10-21 19:20:29', '2025-10-21 19:20:29'),
(15, 'Sulistyorini, SE.', 'Bidang Usaha Koperasi', 'Mengembangkan usaha koperasi dengan inovasi dan strategi bisnis yang tepat', NULL, 'andi.wijaya@koperasi.com', '081234567896', 7, 1, '2025-10-21 19:20:29', '2025-10-21 19:20:29'),
(16, 'Bilal Ali Maghshar Sri Muljono, SST', 'Administrator Koperasi', 'Mengelola sistem informasi dan teknologi untuk mendukung operasional koperasi', NULL, 'eko.prasetyo@koperasi.com', '081234567897', 8, 1, '2025-10-21 19:20:29', '2025-10-21 19:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9GqvUqXQSc07jANSlPMXgF4mwqKymlhlXLF8c2tw', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWThuZ2lSZEdCWXFiaVFIM3o4VTR3b25kcjdENlliU0Q0N0lIZzVqaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbmlzdHJhdG9yL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1761098944),
('lbYew8j0p0oEt5wEOKcIzIjJBmizqUMYh7gJWTBN', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVc5MWlVQUZOazNwYlpZbUpjZXpLS0pOaHVPNVo1ZThSZUlXc3FJayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1761102210),
('YijiQmpLQfMD9co2iObwRfJ43dAkivAS8GuVunQl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZk1yZ3B4VXR4QjVqbEZ5Q3dUcktKZkU4VzdLN1NBaU1VbXA2ZlVabCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761099027);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('peminjam','kepala_bps','bendahara_koperasi','ketua_koperasi','administrator') NOT NULL DEFAULT 'peminjam',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `golongan`, `jabatan`, `phone`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Arrief Chandra Setiawan, S.ST, M.Si.', NULL, NULL, 'Kepala BPS Kota Surabaya', NULL, 'arriefchandra@gmail.com', 'kepala_bps', NULL, '$2y$12$rGnoAX8ysFQNubkRQo52ceetBDECbX8X6HIxYggPQiifN4GFmYXxK', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(2, 'Retno Larasati, S.M.', NULL, NULL, 'Bendahara Koperasi Amanah BPS Kota Surabaya', NULL, 'retnolarasati@gmail.com', 'bendahara_koperasi', NULL, '$2y$12$LIlxqz0a8aRwB9okBPYJ/e1eCnXu/hbnzEsTFylWBewLuQmzBn/8G', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(3, 'Nurcholis, S.Si.', NULL, NULL, 'Ketua Koperasi Amanah BPS Kota Surabaya', NULL, 'nurcholis@gmail.com', 'ketua_koperasi', NULL, '$2y$12$.7Ol.DXCJXUwAJs9jWqHf.YZcV/A3lFiQD/6zddYD3.cKhRxF5LJG', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(4, 'Bilal Ali Maghshar Sri Muljono, SST', NULL, NULL, 'Administrator Website Koperasi Amanah BPS Kota Surabaya', NULL, 'bilalali@gmail.com', 'administrator', NULL, '$2y$12$PIpqdqMnO.iONxovCOeQ8u0DGA9RY.qmn5qNvfDio0Q1s2LztbnJ2', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(8, 'Mohammed Firaz Rajief Bismaka', '23051204330', 'Mahasiwa', 'Magang', '085748867167', 'mohammed.23330@mhs.unesa.ac.id', 'peminjam', NULL, '$2y$12$ppuyMMsFwP4sdGWUIpb1t.4GTbImz4rrIlIc0Cml3YfKTXnVYr9wK', NULL, '2025-10-21 01:05:30', '2025-10-21 01:05:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengurus_koperasis`
--
ALTER TABLE `pengurus_koperasis`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengurus_koperasis`
--
ALTER TABLE `pengurus_koperasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
