-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Oct 25, 2024 at 11:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `beasiswa`
--

CREATE TABLE `beasiswa` (
  `id` int(11) NOT NULL,
  `nama_beasiswa` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beasiswa`
--

INSERT INTO `beasiswa` (`id`, `nama_beasiswa`, `deskripsi`, `kategori`, `deadline`) VALUES
(19, 'Beasiswa LPDP', 'Beasiswa LPDP adalah program beasiswa yang dibiayai oleh pemerintah Indonesia melalui pemanfaatan Dana Pengembangan Pendidikan Nasional (DPPN) yang dikelola oleh Lembaga Pengelola Dana Pendidikan (LPDP) untuk pembiayaan pendidikan tinggi pada program magister atau program doktoral di perguruan tinggi terbaik', 'Akademik', '2024-10-31'),
(20, 'beasiswa KIP Kuliah', 'Kip Kuliah adalah bantuan biaya pendidikan yang diberikan pada mahasiswa baru yang tidak mampu secara ekonomi dan berpotensi akademik baik. Proses perekrutan KIP Kuliah dimulai sebelum pendaftaran seleksi masuk perguruan tinggi.', 'Akademik', '2024-10-30'),
(21, 'Beasiswa Indonesia Maju', 'Beasiswa Indonesia Maju (BIM) adalah program yang diberikan kepada peserta didik atau lulusan yang berprestasi pada bidang akademik dan non-akademik. Beasiswa ini diberikan untuk jenjang S1 dan S2 yang ingin mendaftar ke perguruan tinggi dalam dan luar negeri.', 'Non Akademik', '2024-11-07'),
(22, 'Beasiswa Djarum Plus', 'Beasiswa Djarum Plus merupakan bagian dari Djarum Foundation yang hadir sebagai bukti kontribusi Djarum dalam mendukung pendidikan untuk anak bangsa. Proses beasiswa ini adalah merit based scholarship atau berdasarkan prestasi mahasiswa.', 'Non Akademik', '2024-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `ipk` float DEFAULT NULL,
  `beasiswa_akademik` varchar(100) DEFAULT NULL,
  `beasiswa_non_akademik` varchar(100) DEFAULT NULL,
  `berkas` varchar(255) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Belum Terverifikasi','Terverifikasi') DEFAULT 'Belum Terverifikasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `nama`, `email`, `hp`, `semester`, `ipk`, `beasiswa_akademik`, `beasiswa_non_akademik`, `berkas`, `tanggal_daftar`, `status`) VALUES
(9, 'roberto', 'r.dimassenakusuma@gmail.com', '085786565829', 5, 3.62, 'Beasiswa LPDP', 'Beasiswa Indonesia Maju', 'Nomination Letter_PT HMMI ke SV#5 rev 1 (1) (1).pdf', '2024-10-25 07:15:07', 'Terverifikasi'),
(10, 'robert', 'user1@gmail.com', '08654392382', 5, 3.65, 'Beasiswa LPDP', 'Beasiswa Indonesia Maju', 'Screenshot 2024-10-19 211117.png', '2024-10-25 08:39:37', 'Belum Terverifikasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `nomor_hp`, `password`, `role`, `semester`, `ipk`) VALUES
(1, 'admin', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL),
(14, 'darrielmarkerizal', 'user1@gmail.com', '087986i09', '49457ffbacabe80765b462c5fe0f0b95', 'user', '5', 3.00),
(17, 'ilham', '123@gmail.com', '085786565829', 'c6f057b86584942e415435ffb1fa93d4', 'user', '7', 3.75),
(18, 'robert', 'user1@gmail.com', '08654392382', '202cb962ac59075b964b07152d234b70', 'user', '5', 3.65),
(19, 'user', 'user1@gmail.com', '087986809', '6ad14ba9986e3615423dfca256d04e3f', 'user', '2', 3.00),
(20, 'gento', 'user1@gmail.com', '009876865', '202cb962ac59075b964b07152d234b70', 'user', '5', 2.80),
(21, 'agus', '123@gmail.com', '097967890', 'caf1a3dfb505ffed0d024130f58c5cfa', 'user', '7', 2.60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
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
-- AUTO_INCREMENT for table `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
