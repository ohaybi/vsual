-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2023 at 07:34 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsual_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id_aplikasi` int(11) NOT NULL,
  `nama_aplikasi` varchar(50) NOT NULL,
  `logo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `karya`
--

CREATE TABLE `karya` (
  `id_karya` int(11) NOT NULL,
  `id_kreator` int(11) NOT NULL,
  `judul_karya` varchar(100) NOT NULL,
  `waktu_dibuat` year(4) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karya`
--

INSERT INTO `karya` (`id_karya`, `id_kreator`, `judul_karya`, `waktu_dibuat`, `gambar`, `deskripsi`) VALUES
(24, 23, 'StreamBolt - Livestreaming App', 2023, '63b7f0a87cc99.png', 'Oh, hay! This is my exploration for livestreaming app ui, hope you guys like it ❤️'),
(25, 23, 'NFTLabs - NFT Marketplace Website UI', 2022, '63b7f0c21a7da.png', 'Oh, hay! This is my exploration for NFT marketplace website, hope you guys like it ❤️'),
(26, 24, 'Warata - Modern and Trendy News Portal', 2022, '63b7f1331d97b.png', '/war·ta/ n berita; kabar.');

--
-- Triggers `karya`
--
DELIMITER $$
CREATE TRIGGER `kurang__statistik_karya` BEFORE DELETE ON `karya` FOR EACH ROW BEGIN
	UPDATE statistik SET jumlah = jumlah - 1 WHERE id_statistik = 2;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah__statistik_karya` AFTER INSERT ON `karya` FOR EACH ROW BEGIN
	UPDATE statistik SET jumlah = jumlah + 1 WHERE id_statistik = 2;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kreator`
--

CREATE TABLE `kreator` (
  `id_kreator` int(11) NOT NULL,
  `nama_kreator` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `bio` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kreator`
--

INSERT INTO `kreator` (`id_kreator`, `nama_kreator`, `email`, `username`, `password`, `foto_profil`, `bio`) VALUES
(23, 'Abdillah Mufti', 'muftiabdillah99@gmail.com', 'xmufti', '$2y$10$dVrC4R7qiHpOJ0KBGgAYje02hJAL01iwtWc7kVBfNdZr1EOWmqdz6', '63a1e5a3db14f.png', 'Abdillah Mufti — Badn\'t Creative Designer &amp; Creator of Vsual.'),
(24, 'Amufti', 'muftiabdillah99@gmail.com', 'amufti', '$2y$10$C6sh98C9WlFoFd/dRZdob.0FI24sTsbF5FpzzR4oNM6qsUBuIuQS6', 'default.jpg', '-'),
(25, 'smufti', 'smufti@gmail.com', 'smufti', '$2y$10$0cZ1wSUIFCueQkORB2waR.J6L95Stbaop6zqUp2QjxXEidA.gzf8G', 'default.jpg', '-');

--
-- Triggers `kreator`
--
DELIMITER $$
CREATE TRIGGER `hapus__karya` BEFORE DELETE ON `kreator` FOR EACH ROW BEGIN
	DELETE FROM karya WHERE id_kreator = OLD.id_kreator;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapus__pengalaman` BEFORE DELETE ON `kreator` FOR EACH ROW BEGIN
	DELETE FROM pengalaman WHERE id_kreator = OLD.id_kreator;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapus__sertifikat` BEFORE DELETE ON `kreator` FOR EACH ROW BEGIN
	DELETE FROM sertifikat WHERE id_kreator = OLD.id_kreator;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurang__statistik_kreator` AFTER DELETE ON `kreator` FOR EACH ROW BEGIN
	UPDATE statistik SET jumlah = jumlah - 1 WHERE id_statistik = 1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah__statistik_kreator` AFTER INSERT ON `kreator` FOR EACH ROW BEGIN
	UPDATE statistik SET jumlah = jumlah + 1 WHERE id_statistik = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman`
--

CREATE TABLE `pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `id_kreator` int(11) NOT NULL,
  `posisi_jabatan` varchar(100) NOT NULL,
  `nama_institusi` varchar(100) NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `tahun_selesai` year(4) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengalaman`
--

INSERT INTO `pengalaman` (`id_pengalaman`, `id_kreator`, `posisi_jabatan`, `nama_institusi`, `tahun_mulai`, `tahun_selesai`, `deskripsi`) VALUES
(8, 23, 'Mahasiswa', 'Universitas Padimas (UNPADI)', 2019, 2020, 'Program Studi Desain Komunikasi Vsual'),
(9, 23, 'Creator', 'Vsual Indonesia', 2020, 2022, 'Creator of Vsual Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_kreator` int(11) NOT NULL,
  `judul_sertifikat` varchar(100) NOT NULL,
  `nama_institusi` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sertifikat`
--

INSERT INTO `sertifikat` (`id_sertifikat`, `id_kreator`, `judul_sertifikat`, `nama_institusi`, `tahun_terbit`) VALUES
(5, 23, 'Dasar Pemrograman Web', 'Dicoding Academy', 2022),
(6, 23, 'Front-End Web untuk Pemula', 'Dicoding Academy', 2022);

-- --------------------------------------------------------

--
-- Table structure for table `statistik`
--

CREATE TABLE `statistik` (
  `id_statistik` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statistik`
--

INSERT INTO `statistik` (`id_statistik`, `nama`, `jumlah`) VALUES
(1, 'kreator', 3),
(2, 'karya', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id_aplikasi`);

--
-- Indexes for table `karya`
--
ALTER TABLE `karya`
  ADD PRIMARY KEY (`id_karya`),
  ADD KEY `fk_karya_kreator` (`id_kreator`);

--
-- Indexes for table `kreator`
--
ALTER TABLE `kreator`
  ADD PRIMARY KEY (`id_kreator`);

--
-- Indexes for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD PRIMARY KEY (`id_pengalaman`),
  ADD KEY `fk_pengalaman_kreator` (`id_kreator`);

--
-- Indexes for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD KEY `fk_sertifikat_kreator` (`id_kreator`);

--
-- Indexes for table `statistik`
--
ALTER TABLE `statistik`
  ADD PRIMARY KEY (`id_statistik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karya`
--
ALTER TABLE `karya`
  MODIFY `id_karya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kreator`
--
ALTER TABLE `kreator`
  MODIFY `id_kreator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pengalaman`
--
ALTER TABLE `pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `statistik`
--
ALTER TABLE `statistik`
  MODIFY `id_statistik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karya`
--
ALTER TABLE `karya`
  ADD CONSTRAINT `fk_karya_kreator` FOREIGN KEY (`id_kreator`) REFERENCES `kreator` (`id_kreator`);

--
-- Constraints for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD CONSTRAINT `fk_pengalaman_kreator` FOREIGN KEY (`id_kreator`) REFERENCES `kreator` (`id_kreator`);

--
-- Constraints for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `fk_sertifikat_kreator` FOREIGN KEY (`id_kreator`) REFERENCES `kreator` (`id_kreator`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
