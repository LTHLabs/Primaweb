-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 03:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','archived') NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(3, 'nabila', 'nabilafarma23@gmail.com', '08319332672', 'cinta', 'Saya cinta rasulullah🩷', 'new', '2025-11-09 21:50:47', NULL),
(4, 'nabila', 'lthpoeradiredja@gmail.com', '083192957234', 'Pesan', 'contoh pesan test', 'new', '2025-11-09 21:54:41', NULL),
(5, 'Bahlil Lahadalia', 'etanolbahlil99@gmail.com', '08216255221', 'Pertamax', 'Bahlil Lahadalia mengeluh karena korupsi tata kelola minyak dan gas bumi (migas) di ketahui.', 'new', '2025-11-12 20:12:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_siswa`
--

CREATE TABLE `pendaftaran_siswa` (
  `id_pendaftaran` int(11) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL,
  `program_keahlian` enum('Rekayasa Perangkat Lunak (RPL)','Teknik Komputer Jaringan (TKJ)','Desain Komunikasi Visual (DKV)') DEFAULT NULL,
  `foto_formal` varchar(255) DEFAULT NULL,
  `foto_ijazah` varchar(255) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran_siswa`
--

INSERT INTO `pendaftaran_siswa` (`id_pendaftaran`, `nisn`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `asal_sekolah`, `no_hp`, `email`, `token`, `token_expired`, `program_keahlian`, `foto_formal`, `foto_ijazah`, `tanggal_daftar`) VALUES
(1, '1234565432', 'Marc Marquez', 'Sigong', '2018-05-20', 'Laki-laki', 'Desa Sigong, Kecamatan Lemahabang, Kabupaten Cirebon, Provinsi Jawa Barat', 'SMPN 1 Lemahabang', '081638749153', 'Marquez93@gmail.com', NULL, NULL, 'Rekayasa Perangkat Lunak (RPL)', 'uploads/6915f0efa71bb_stop kontak.png', 'uploads/6915f0efb7b16_cv pb.jpg', '2025-11-13 21:53:35'),
(3, '537916352', 'Fabio Quartararo', 'Sigong', '2025-11-05', 'Laki-laki', 'Desa Sigong, Kecamatan Lemahabang, Kabupaten Cirebon, Provinsi Jawa Barat', 'SMPN 1 Lemahabang', '081634872746', 'quartararo20@gmail.com', NULL, NULL, 'Teknik Komputer Jaringan (TKJ)', 'uploads/6915f1b0198e9_Kabel USB ESP32.png', 'uploads/6915f1b01a006_cv pb.jpg', '2025-11-13 21:56:48'),
(4, '1638274627', 'Lewis Hamilton', 'London', '2025-11-02', 'Laki-laki', 'Londong, The United Kingdom', 'SMPN 1 London', '081648298476', 'hamiltonf1@gmail.com', NULL, NULL, 'Desain Komunikasi Visual (DKV)', 'uploads/6915f2fa4938a_lampu1.png', 'uploads/6915f2fa49b8e_cv pb.jpg', '2025-11-13 22:02:18'),
(5, '1537284627', 'Siti Julaeha', 'Bogor', '2025-11-02', 'Perempuan', 'Bogor, Jawa Barat', 'SMPN 1 Bogor', '081637284926', 'sj16455@gmail.com', NULL, NULL, 'Rekayasa Perangkat Lunak (RPL)', 'uploads/69172fc2d4848_stop kontak.png', 'uploads/69172fc2d4fb8_cv pb.jpg', '2025-11-14 20:33:54'),
(6, '1237384756', 'Siti Julaeha', 'Bogor', '2025-11-02', 'Perempuan', 'Bogor, Jawa Barat', 'SMPN 1 Bogor', '081625384765', 'sj1645155@gmail.com', NULL, NULL, 'Rekayasa Perangkat Lunak (RPL)', 'uploads/6917307013564_stop kontak.png', 'uploads/69173070139e8_cv pb.jpg', '2025-11-14 20:36:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `pendaftaran_siswa`
--
ALTER TABLE `pendaftaran_siswa`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `nisn` (`nisn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pendaftaran_siswa`
--
ALTER TABLE `pendaftaran_siswa`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
