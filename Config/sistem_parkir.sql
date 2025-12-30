-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2025 at 06:49 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tarif_parkir`
--

CREATE TABLE `tarif_parkir` (
  `id_tarif` int NOT NULL,
  `jenis_kendaraan` enum('motor','mobil') NOT NULL,
  `harga_flat` int NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tarif_parkir`
--

INSERT INTO `tarif_parkir` (`id_tarif`, `jenis_kendaraan`, `harga_flat`, `updated_at`) VALUES
(1, 'motor', 5000, '2025-12-28 18:17:23'),
(2, 'mobil', 10000, '2025-11-18 09:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int NOT NULL,
  `barcode` char(13) NOT NULL,
  `nomor_polisi` varchar(15) DEFAULT NULL,
  `jenis_kendaraan` enum('motor','mobil') NOT NULL,
  `id_tarif` int NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `id_petugas_masuk` int DEFAULT NULL,
  `id_petugas_keluar` int DEFAULT NULL,
  `status` enum('masuk','keluar') DEFAULT 'masuk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `barcode`, `nomor_polisi`, `jenis_kendaraan`, `id_tarif`, `tgl_masuk`, `tgl_keluar`, `total_harga`, `id_petugas_masuk`, `id_petugas_keluar`, `status`) VALUES
(1, '0000000000020', 'B 0001 TT', 'mobil', 2, '2025-12-29 13:00:00', '2025-12-29 16:00:00', 10000, NULL, 1, 'keluar'),
(2, '0000000000019', 'B 9999 SS', 'motor', 1, '2025-12-29 09:00:00', '2025-12-29 11:00:00', 5000, 1, NULL, 'keluar'),
(3, '0000000000018', 'B 8888 RR', 'mobil', 2, '2025-12-29 07:00:00', '2025-12-29 10:00:00', 10000, NULL, 1, 'keluar'),
(4, '0000000000017', 'B 7777 QQ', 'motor', 1, '2025-12-28 15:30:00', '2025-12-28 17:00:00', 5000, 1, NULL, 'keluar'),
(5, '0000000000016', 'B 6666 PP', 'mobil', 2, '2025-12-28 09:00:00', '2025-12-28 12:00:00', 10000, NULL, 1, 'keluar'),
(6, '0000000000015', 'B 5555 OO', 'motor', 1, '2025-12-28 08:20:00', '2025-12-28 10:00:00', 5000, 1, NULL, 'keluar'),
(7, '0000000000014', 'B 4444 NN', 'mobil', 2, '2025-12-27 14:00:00', '2025-12-27 17:00:00', 10000, NULL, 1, 'keluar'),
(8, '0000000000013', 'B 3333 MM', 'motor', 1, '2025-12-27 09:30:00', '2025-12-27 11:30:00', 5000, 1, NULL, 'keluar'),
(9, '0000000000012', 'B 2222 LL', 'mobil', 2, '2025-12-27 08:00:00', '2025-12-27 11:00:00', 10000, NULL, 1, 'keluar'),
(10, '0000000000011', 'B 1111 KK', 'motor', 1, '2025-12-26 16:00:00', '2025-12-26 18:00:00', 5000, 1, NULL, 'keluar'),
(11, '0000000000010', 'B 0123 JJ', 'mobil', 2, '2025-12-26 10:00:00', '2025-12-26 13:00:00', 10000, NULL, 1, 'keluar'),
(12, '0000000000009', 'B 9012 II', 'motor', 1, '2025-12-26 07:30:00', '2025-12-26 09:00:00', 5000, 1, NULL, 'keluar'),
(13, '0000000000008', 'B 8901 HH', 'mobil', 2, '2025-12-25 15:00:00', '2025-12-25 18:00:00', 10000, NULL, 1, 'keluar'),
(14, '0000000000007', 'B 7890 GG', 'motor', 1, '2025-12-25 09:10:00', '2025-12-25 11:00:00', 5000, 1, NULL, 'keluar'),
(15, '0000000000006', 'B 6789 FF', 'mobil', 2, '2025-12-25 08:30:00', '2025-12-25 11:30:00', 10000, NULL, 1, 'keluar'),
(16, '0000000000005', 'B 5678 EE', 'motor', 1, '2025-12-24 14:00:00', '2025-12-24 16:00:00', 5000, 1, NULL, 'keluar'),
(17, '0000000000004', 'B 4567 DD', 'mobil', 2, '2025-12-24 10:00:00', '2025-12-24 13:00:00', 10000, NULL, 1, 'keluar'),
(18, '0000000000003', 'B 3456 CC', 'motor', 1, '2025-12-24 07:50:00', '2025-12-24 09:30:00', 5000, 1, NULL, 'keluar'),
(19, '0000000000002', 'B 2345 BB', 'mobil', 2, '2025-12-23 09:00:00', '2025-12-23 12:00:00', 10000, NULL, 1, 'keluar'),
(20, '0000000000001', 'B 1234 AA', 'motor', 1, '2025-12-23 08:10:00', '2025-12-23 10:00:00', 5000, 1, NULL, 'keluar');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_tiket` int NOT NULL,
  `jumlah_bayar` int NOT NULL,
  `metode` enum('cash','digital') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'cash',
  `tgl_bayar` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_tiket`, `jumlah_bayar`, `metode`, `tgl_bayar`, `status`) VALUES
(1, 1, 5000, 'cash', '2025-12-23 10:00:00', 'paid'),
(2, 2, 10000, 'digital', '2025-12-23 12:00:00', 'paid'),
(3, 3, 5000, 'cash', '2025-12-24 09:30:00', 'paid'),
(4, 4, 10000, 'digital', '2025-12-24 13:00:00', 'paid'),
(5, 5, 5000, 'cash', '2025-12-24 16:00:00', 'paid'),
(6, 6, 10000, 'digital', '2025-12-25 11:30:00', 'paid'),
(7, 7, 5000, 'cash', '2025-12-25 11:00:00', 'paid'),
(8, 8, 10000, 'digital', '2025-12-25 18:00:00', 'paid'),
(9, 9, 5000, 'cash', '2025-12-26 09:00:00', 'paid'),
(10, 10, 10000, 'digital', '2025-12-26 13:00:00', 'paid'),
(11, 11, 5000, 'cash', '2025-12-26 18:00:00', 'paid'),
(12, 12, 10000, 'digital', '2025-12-27 11:00:00', 'paid'),
(13, 13, 5000, 'cash', '2025-12-27 11:30:00', 'paid'),
(14, 14, 10000, 'digital', '2025-12-27 17:00:00', 'paid'),
(15, 15, 5000, 'cash', '2025-12-28 10:00:00', 'paid'),
(16, 16, 10000, 'digital', '2025-12-28 12:00:00', 'paid'),
(17, 17, 5000, 'cash', '2025-12-28 17:00:00', 'paid'),
(18, 18, 10000, 'digital', '2025-12-29 10:00:00', 'paid'),
(19, 19, 5000, 'cash', '2025-12-29 11:00:00', 'paid'),
(20, 20, 10000, 'digital', '2025-12-29 16:00:00', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `role` enum('admin','petugas') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'petugas',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `email_verified_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verification_sent_at` datetime DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `email`, `password`, `gender`, `role`, `created_at`, `email_verified_at`, `verification_token`, `verification_sent_at`, `reset_password_token`, `reset_password_expired_at`) VALUES
(1, 'Fadlan Firdaus', 'fadlanfirdaus220@gmail.com', '$2y$10$wjoRlPpXG9hh/anoK5Rt0e88NOm4POCJVxy0xRk7of2zVyz.adc1a', 'L', 'admin', '2025-11-24 17:19:15', '2025-12-30 17:20:00', NULL, NULL, NULL, NULL),
(2, 'Fadlan Firdaus', 'fadlanfirdaus225@gmail.com', '$2y$10$BM.53as3fZhHAQNVNzPUyOj6tGzUULrisWqWegxZs9agQaKBHl9Qm', 'L', 'petugas', '2025-12-29 17:24:50', '2025-12-29 17:30:00', NULL, NULL, NULL, NULL),
(3, 'Fadlan', '24_fadlan@student.smkti.net', '$2y$10$zqtai68MrQBKMo.XmE0MRug4GoljXhDj0E/iBu.eKG4UKg.HIKGzm', 'L', 'petugas', '2025-12-27 17:26:11', '2025-12-28 17:30:00', NULL, NULL, NULL, NULL),
(4, 'Andik A Dilma', 'andik@gmail.com', '$2y$10$PMo0n6jpXQk12m.avIuNGOtvoww6imRbL.cun8eudaMSxWGtrepxi', 'P', 'petugas', '2025-12-01 17:30:09', NULL, NULL, NULL, NULL, NULL),
(5, 'Admin Palsu', 'addminpalsu@gmail.com', '$2y$10$Kx1ALP.aEXUVbyllJfDV/.QbUrj5rYk0qkvFi1oDFP6pe/M9lKM82', 'P', 'admin', '2025-12-30 17:41:19', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tarif_parkir`
--
ALTER TABLE `tarif_parkir`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `id_tarif` (`id_tarif`),
  ADD KEY `tiket_ibfk_2` (`id_petugas_masuk`),
  ADD KEY `tiket_ibfk_3` (`id_petugas_keluar`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_tiket` (`id_tiket`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tarif_parkir`
--
ALTER TABLE `tarif_parkir`
  MODIFY `id_tarif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif_parkir` (`id_tarif`),
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`id_petugas_masuk`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `tiket_ibfk_3` FOREIGN KEY (`id_petugas_keluar`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
