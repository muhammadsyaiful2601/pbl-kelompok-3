-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2026 at 02:02 PM
-- Server version: 8.4.7
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

DROP TABLE IF EXISTS `sekolah`;
CREATE TABLE IF NOT EXISTS `sekolah` (
  `id_sekolah` int NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(150) NOT NULL,
  `jenjang` enum('SD','SMP') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `alamat` text NOT NULL,
  `jumlah_siswa` int DEFAULT NULL,
  `deskripsi_sekolah` text,
  `website` varchar(255) DEFAULT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `tipe_objek` enum('marker','polygon') DEFAULT 'marker',
  `koordinat_polygon` text,
  PRIMARY KEY (`id_sekolah`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `jenjang`, `foto`, `alamat`, `jumlah_siswa`, `deskripsi_sekolah`, `website`, `latitude`, `longitude`, `created_at`, `tipe_objek`, `koordinat_polygon`) VALUES
(6, 'smp ', 'SMP', '1780881273_66f5ca5fa177e9dd0c4e.png', 'beverly hills', 1000000, '', '', '-0.47506383933517804', '100.62117455893257', '2026-06-08 08:14:33', 'marker', NULL),
(7, 'smp ', 'SD', '', 'beverly hils', 1000, '', NULL, '-0.4917591029532484', '100.61904270810244', '2026-06-08 08:47:25', 'marker', NULL),
(8, 'SD', 'SD', '', 'beverly hils', 4, '', NULL, '-0.4718470873581548', '100.64257973673564', '2026-06-08 08:50:41', 'marker', NULL),
(9, 'SD', 'SD', '', 'beverly hills', 978, '', NULL, '-0.48248972362600034', '100.62299418006278', '2026-06-08 08:51:57', 'marker', NULL),
(10, 'SD', 'SD', '1780968138_6a777892f93c57808b15.png', 'beverly hills', 132, '', 'https://github.com/muhammadsyaiful2601', '-0.4816386936194963', '100.62434945218946', '2026-06-09 08:22:18', 'marker', NULL),
(11, 'SD', 'SD', '', 'beverly hills', 2601, '', 'https://github.com/muhammadsyaiful2601', '-0.4536739267440354', '100.59428333099102', '2026-06-10 17:07:10', 'marker', NULL),
(12, 'smp ', 'SMP', '', 'beverly hills', 10, '', '', '-0.490729', '100.616809', '2026-06-10 20:59:09', 'marker', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
