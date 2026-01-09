-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni_profiles`
--

CREATE TABLE `alumni_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(30) DEFAULT NULL,
  `nama_lengkap` varchar(120) NOT NULL,
  `foto_path` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `jurusan` varchar(120) DEFAULT NULL,
  `pekerjaan` varchar(120) DEFAULT NULL,
  `pekerjaan_detail` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni_profiles`
--

INSERT INTO `alumni_profiles` (`id`, `user_id`, `nim`, `nama_lengkap`, `foto_path`, `tempat_lahir`, `tanggal_lahir`, `angkatan`, `jurusan`, `pekerjaan`, `pekerjaan_detail`, `deskripsi`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(13, 15, 'K3524020', 'Dexa', 'uploads/5e9822e20a71182da2d79f67fb50a04b.jpeg', 'Klaten', '2006-01-01', '2024', 'PTIK', 'Programmer', 'Programmer AI at Microsoft', 'Just a chill guy', 'verified', '2025-10-08 07:59:41', '2025-10-08 08:05:31'),
(14, 16, NULL, 'Aku Admin', NULL, '', NULL, NULL, '', '', '', '', 'verified', '2025-10-08 08:02:22', '2025-10-08 08:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','alumni') NOT NULL DEFAULT 'alumni',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 'dexa@uns.ac.id', '$2y$10$DGdoPYs/CP/rMbxdRL6CYOJRwkU307k.PRtiSuNh8FSg26fVCYkWK', 'alumni', 1, '2025-10-08 07:59:41', '2025-10-08 07:59:41'),
(16, 'admin@uns.ac.id', '$2y$10$.XZhu5mr5.lQm5nqtCbuS.VA2/1DuKnztpNda4q.ENV51ydTGwq/e', 'admin', 1, '2025-10-08 08:02:22', '2025-10-08 08:03:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_profiles`
--
ALTER TABLE `alumni_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_alumni_nama` (`nama_lengkap`),
  ADD KEY `idx_alumni_angkatan` (`angkatan`),
  ADD KEY `idx_alumni_status` (`status_verifikasi`),
  ADD KEY `idx_alumni_pekerjaan` (`pekerjaan`),
  ADD KEY `idx_alumni_jurusan` (`jurusan`),
  ADD KEY `idx_alumni_nim` (`nim`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni_profiles`
--
ALTER TABLE `alumni_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_profiles`
--
ALTER TABLE `alumni_profiles`
  ADD CONSTRAINT `fk_alumni_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
