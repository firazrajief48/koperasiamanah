-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 10:23 AM
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
-- Table structure for table `iurans`
--

CREATE TABLE `iurans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bulan` varchar(20) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `status` enum('lunas','belum') NOT NULL DEFAULT 'belum',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(6, '2025_10_22_020253_create_pengurus_koperasis_table', 2),
(7, '2025_10_24_031223_add_photo_to_users_table', 3),
(8, '2025_10_28_010517_create_iurans_table', 4),
(9, '2025_10_28_010523_create_pinjamans_table', 4),
(12, '2025_10_29_020730_add_workflow_fields_to_pinjamans_table', 5),
(14, '2025_10_29_021617_add_status_tracking_to_pinjamans_table', 6),
(15, '2025_10_29_031448_update_user_role_enum_to_anggota', 6),
(16, '2025_10_29_063414_add_metode_pembayaran_to_pinjamans_table', 7);

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
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pinjaman_id` bigint(20) UNSIGNED NOT NULL,
  `bulan_ke` int(11) NOT NULL,
  `nominal_pembayaran` decimal(15,2) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `status` enum('belum_bayar','sudah_bayar','terlambat') NOT NULL DEFAULT 'belum_bayar',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `pinjaman_id`, `bulan_ke`, `nominal_pembayaran`, `tanggal_jatuh_tempo`, `tanggal_pembayaran`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2000000.00, '2025-11-30', NULL, 'belum_bayar', NULL, '2025-10-30 01:04:59', '2025-10-30 01:04:59'),
(2, 3, 2, 2000000.00, '2025-12-30', NULL, 'belum_bayar', NULL, '2025-10-30 01:04:59', '2025-10-30 01:04:59');

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
(1, 'Dr. Arrief Chandra Setiawan, S.ST, M.Si.', 'Kepala BPS', 'Memimpin dengan visi yang jelas dan dedikasi tinggi untuk kemajuan koperasi.', 'pengurus/1761270754_dr-arrief-chandra-setiawan-sst-msi.jpg', 'arriefchandra@gmail.com', '082257649266', 1, 1, '2025-10-21 19:03:56', '2025-10-23 18:52:34'),
(2, 'Nurcholis, S.Si.', 'Ketua Koperasi', 'Memimpin koperasi dengan integritas dan komitmen untuk kesejahteraan anggota', 'pengurus/1761270785_nurcholis-ssi.jpg', 'nurcholis@gmail.com', '081234567891', 2, 1, '2025-10-21 19:03:56', '2025-10-23 18:53:05'),
(3, 'Fadjar Suhaeri, SE, M.SE.', 'Wakil Ketua Koperasi', 'Mendukung kepemimpinan dengan pengalaman dan dedikasi yang tinggi', 'pengurus/1761270830_fadjar-suhaeri-se-mse.jpg', 'fadjarsuhaeri@gmail.com', '081234567892', 3, 1, '2025-10-21 19:03:56', '2025-10-23 18:53:50'),
(6, 'Fitri Kusumowardhani, SST', 'Bendahara Koperasi 2', 'Mendukung pengelolaan keuangan dengan keahlian akuntansi yang mumpuni', 'pengurus/1761270867_fitri-kusumowardhani-sst.jpg', 'fitrikusumowardhani@gmail.com', '081234567895', 6, 1, '2025-10-21 19:03:56', '2025-10-23 18:54:27'),
(12, 'Iir Lismawati, S.Si.', 'Sekretaris Koperasi', 'Mengorganisir administrasi dengan profesional dan teliti', 'pengurus/1761270841_iir-lismawati-ssi.jpg', 'iirlismawati@gmail.com', '081234567893', 4, 1, '2025-10-21 19:20:29', '2025-10-23 18:54:01'),
(13, 'Retno Larasati, S.M.', 'Bendahara Koperasi 1', 'Mengelola keuangan dengan transparansi dan akuntabilitas tinggi', 'pengurus/1761270854_retno-larasati-sm.jpg', 'retnolarasati@gmail.com', '081234567894', 5, 1, '2025-10-21 19:20:29', '2025-10-23 18:54:14'),
(15, 'Sulistyorini, SE.', 'Bidang Usaha Koperasi', 'Mengembangkan usaha koperasi dengan inovasi dan strategi bisnis yang tepat', 'pengurus/1761270877_sulistyorini-se.jpg', 'sulistyorini@gmail.com', '081234567896', 7, 1, '2025-10-21 19:20:29', '2025-10-23 18:54:37'),
(16, 'Bilal Ali Maghshar Sri Muljono, SST', 'Administrator Koperasi', 'Mengelola sistem informasi dan teknologi untuk mendukung operasional koperasi', 'pengurus/1761270888_bilal-ali-maghshar-sri-muljono-sst.jpg', 'bilalali@gmail.com', '081234567897', 8, 1, '2025-10-21 19:20:29', '2025-10-23 18:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `pinjamans`
--

CREATE TABLE `pinjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_pinjaman` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tenor_bulan` int(11) NOT NULL DEFAULT 0,
  `cicilan_per_bulan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bulan_terbayar` int(11) NOT NULL DEFAULT 0,
  `sisa_pinjaman` decimal(15,2) NOT NULL DEFAULT 0.00,
  `gaji_pokok` decimal(15,2) DEFAULT NULL,
  `metode_pembayaran` enum('potong_gaji','potong_tukin') DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','lunas') NOT NULL DEFAULT 'menunggu',
  `status_detail` varchar(255) NOT NULL DEFAULT 'menunggu_persetujuan_bendahara',
  `alasan_penolakan` text DEFAULT NULL,
  `disetujui_oleh` varchar(255) DEFAULT NULL,
  `tanggal_persetujuan` timestamp NULL DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjamans`
--

INSERT INTO `pinjamans` (`id`, `user_id`, `jumlah_pinjaman`, `tenor_bulan`, `cicilan_per_bulan`, `bulan_terbayar`, `sisa_pinjaman`, `gaji_pokok`, `metode_pembayaran`, `status`, `status_detail`, `alasan_penolakan`, `disetujui_oleh`, `tanggal_persetujuan`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 9, 5000000.00, 2, 2500000.00, 0, 5000000.00, 30000000.00, NULL, 'menunggu', 'menunggu_persetujuan_ketua', NULL, 'Retno Larasati, S.M.', '2025-10-29 01:50:44', 'Biaya Keperluan', '2025-10-28 20:27:01', '2025-10-29 01:50:44'),
(3, 9, 4000000.00, 2, 2000000.00, 0, 4000000.00, 10000000.00, 'potong_tukin', 'menunggu', 'ditolak', 'Hutang Kemarin Belum Lunas!', 'Retno Larasati, S.M.', '2025-10-30 01:06:07', 'WKWKWKWKWK', '2025-10-30 01:04:59', '2025-10-30 01:06:07');

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
('A00TdSot8HprwoEzj6FfhxzPM9HIXzTQc7661S7E', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakdCOHZGOTFjam43enVpUHRuc0VIZGd0RFFwZktUaFdYa1N2RkI4UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iZW5kYWhhcmEta29wZXJhc2kvbGFwb3Jhbi1waW5qYW1hbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761813202);

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
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('anggota','kepala_bps','bendahara_koperasi','ketua_koperasi','administrator') NOT NULL DEFAULT 'anggota',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `golongan`, `jabatan`, `phone`, `photo`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Arrief Chandra Setiawan, S.ST, M.Si.', NULL, NULL, 'Kepala BPS Kota Surabaya', NULL, NULL, 'arriefchandra@gmail.com', 'kepala_bps', NULL, '$2y$12$rGnoAX8ysFQNubkRQo52ceetBDECbX8X6HIxYggPQiifN4GFmYXxK', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(2, 'Retno Larasati, S.M.', NULL, NULL, 'Bendahara Koperasi Amanah BPS Kota Surabaya', NULL, NULL, 'retnolarasati@gmail.com', 'bendahara_koperasi', NULL, '$2y$12$LIlxqz0a8aRwB9okBPYJ/e1eCnXu/hbnzEsTFylWBewLuQmzBn/8G', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(3, 'Nurcholis, S.Si.', NULL, NULL, 'Ketua Koperasi Amanah BPS Kota Surabaya', NULL, NULL, 'nurcholis@gmail.com', 'ketua_koperasi', NULL, '$2y$12$.7Ol.DXCJXUwAJs9jWqHf.YZcV/A3lFiQD/6zddYD3.cKhRxF5LJG', NULL, '2025-10-21 00:10:09', '2025-10-21 00:10:09'),
(4, 'Bilal Ali Maghshar Sri Muljono, SST', '', '', 'Administrator Website Koperasi Amanah BPS Kota Surabaya', '', NULL, 'bilalali@gmail.com', 'administrator', NULL, '$2y$12$PIpqdqMnO.iONxovCOeQ8u0DGA9RY.qmn5qNvfDio0Q1s2LztbnJ2', NULL, '2025-10-21 00:10:09', '2025-10-26 18:51:35'),
(9, 'Mohammed Firaz Rajief Bismaka', '23051204330', 'Magang', 'Mahasiswa', '085748867167', NULL, 'mohammed.23330@mhs.unesa.ac.id', 'anggota', NULL, '$2y$12$X9RyUBn8c6QEb4y4CYs/Fep0gauUkEKl93M/cUJeMECWKwQkN4YOe', NULL, '2025-10-22 20:50:12', '2025-10-28 01:32:55');

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
-- Indexes for table `iurans`
--
ALTER TABLE `iurans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iurans_user_id_index` (`user_id`),
  ADD KEY `iurans_bulan_index` (`bulan`);

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
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengurus_koperasis`
--
ALTER TABLE `pengurus_koperasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjamans`
--
ALTER TABLE `pinjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjamans_user_id_index` (`user_id`),
  ADD KEY `pinjamans_status_index` (`status`);

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
-- AUTO_INCREMENT for table `iurans`
--
ALTER TABLE `iurans`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengurus_koperasis`
--
ALTER TABLE `pengurus_koperasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pinjamans`
--
ALTER TABLE `pinjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iurans`
--
ALTER TABLE `iurans`
  ADD CONSTRAINT `iurans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pinjamans`
--
ALTER TABLE `pinjamans`
  ADD CONSTRAINT `pinjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
