-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251108.4354f4b246
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2026 at 09:39 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `womanpreneur_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kas_harian`
--

CREATE TABLE `kas_harian` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int NOT NULL,
  `harga` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kas_harian`
--

INSERT INTO `kas_harian` (`id`, `tanggal`, `nama_barang`, `jumlah`, `harga`, `created_at`) VALUES
(1, '2025-07-06', 'Ketoprak', 45, 20000, '2026-03-14 05:56:15'),
(2, '2025-07-07', 'Ketoprak', 35, 20000, '2026-03-14 05:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text,
  `harga` bigint NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `foto`, `created_at`) VALUES
(2, 'Ketoprak Indomie', 'Kuliner inovasi yang memadukan ketoprak Betawi dengan Indomie goreng, menggantikan atau menambah bihun', 20000, 'uploads/1773469977_download (1).jpg', '2026-03-14 06:32:57'),
(3, 'Nasi Goreng', 'Hidangan ikonik Indonesia berupa nasi yang ditumis dengan kecap manis, terasi, bawang, dan bumbu rempah, menghasilkan cita rasa gurih-manis yang khas', 25000, 'uploads/1773470040_download.jpg', '2026-03-14 06:34:00'),
(4, 'Test', 'test', 200000, 'uploads/1773470050_d4ad6ffbe58eb6443e8076b228b7cab0.jpg', '2026-03-14 06:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin123', '2026-03-14 05:56:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas_harian`
--
ALTER TABLE `kas_harian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas_harian`
--
ALTER TABLE `kas_harian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
