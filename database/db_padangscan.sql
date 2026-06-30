-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 08:32 PM
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
-- Database: `db_padangscan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nomor_handphone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `nomor_handphone`) VALUES
(1, 'Nurun Nihayatur', 'Nurunniha34@gmail.com', '085678902876'),
(2, 'Dennis Ma\'rifatul Kurnia', 'denniskrn123@gmail.com', '08123456789');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_cabang` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id`, `nama_cabang`, `alamat`, `status`) VALUES
(1, 'RM. Siang Malam Masakan Padang  Cabang 1', 'Jalan Argo Wilis No.378 Kota Kediri', 'Aktif'),
(2, 'RM. Siang Malam Masakan Padang Cabang 2', 'Jalan Argo Wilis No.551 Kota Kediri', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `no_karyawan` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `tmt` date NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `id_cabang`, `id_user`, `no_karyawan`, `nama`, `nomor_telepon`, `tmt`, `tanggal_lahir`, `tempat_lahir`, `gambar`) VALUES
(1, 1, 17, 'CB01-2001', 'Putri Ameliya', '0879-9876-4908', '2024-09-11', '2003-05-14', 'Kediri', 'uploads/202501050227381.png'),
(19, 1, 20, 'CB01-2002', 'Cindy Avitaselly B.S', '08123456789', '2024-11-01', '2000-02-02', 'Kediri', 'uploads/202501050205321.png'),
(23, 2, 24, 'CB02-3001', 'Dennis Ma\'rifatul Kurnia', '086735678901', '2024-11-21', '2006-02-01', 'Kediri', 'uploads/20250105020707.png'),
(24, 2, 25, 'CB02-3002', 'Nurun Nihayatur R.A', '081345678097', '2024-12-10', '2003-02-08', 'Kediri', 'uploads/20250105022626.png');

-- --------------------------------------------------------

--
-- Table structure for table `presensi_pegawai`
--

CREATE TABLE `presensi_pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `tanggal_waktu` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi_pegawai`
--

INSERT INTO `presensi_pegawai` (`id`, `id_pegawai`, `tanggal_waktu`, `status`, `jenis`) VALUES
(1, 1, '2024-11-24 20:54:09', 'Hadir', 'Pulang'),
(2, 1, '2024-11-25 00:00:00', 'Sakit', ''),
(3, 1, '2024-11-25 00:00:00', 'Sakit', ''),
(4, 1, '2024-11-25 12:41:00', 'Hadir', 'Pulang'),
(5, 1, '2024-11-30 20:34:52', 'Hadir', 'Pulang'),
(6, 1, '2024-12-02 12:39:36', 'Hadir', 'Pulang'),
(7, 19, '2024-12-02 00:00:00', 'Izin', ''),
(8, 1, '2024-12-02 12:50:14', 'Hadir', 'Masuk'),
(9, 1, '2024-12-15 01:38:01', 'Hadir', 'Masuk'),
(10, 19, '2024-12-15 00:00:00', 'Izin', ''),
(11, 1, '2024-12-15 00:00:00', 'Sakit', ''),
(12, 1, '2024-12-15 13:57:47', 'Hadir', 'Pulang'),
(13, 19, '2024-12-15 14:00:18', 'Hadir', 'Pulang'),
(15, 19, '2024-12-15 00:00:00', 'Izin', ''),
(35, 19, '2024-12-16 01:03:00', 'Hadir', 'Masuk'),
(38, 1, '2024-12-19 20:24:15', 'Hadir', 'Pulang'),
(39, 1, '2024-12-30 22:47:15', 'Hadir', 'Pulang'),
(44, 19, '2024-12-30 22:49:31', 'Hadir', 'Pulang');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'admin', 'ADMIN'),
(17, 'CB01-2001', '123', 'PEGAWAI'),
(20, 'CB01-2002', '123', 'PEGAWAI'),
(24, 'CB02-3001', '123', 'PEGAWAI'),
(25, 'CB02-3002', '123', 'PEGAWAI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cabang` (`id_cabang`);

--
-- Indexes for table `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  ADD CONSTRAINT `presensi_pegawai_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
