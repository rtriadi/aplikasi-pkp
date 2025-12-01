-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 01:40 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_epkp`
--

-- --------------------------------------------------------

--
-- Table structure for table `pkp_indicators`
--

CREATE TABLE `pkp_indicators` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `indicator_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pkp_indicators`
--

INSERT INTO `pkp_indicators` (`id`, `user_id`, `year_id`, `indicator_name`) VALUES
(1, 2, 1, 'TEKNOLOGI INFORMASI TERKELOLA DENGAN BAIK DAN AKUNTABEL'),
(2, 2, 1, 'DOKUMEN PELAPORAN TERKELOLA DENGAN BAIK DAN AKUNTABEL');

-- --------------------------------------------------------

--
-- Table structure for table `pkp_monthly`
--

CREATE TABLE `pkp_monthly` (
  `id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `real_qty` int(11) DEFAULT 0,
  `real_quality` int(11) DEFAULT 0,
  `is_active_print` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pkp_monthly`
--

INSERT INTO `pkp_monthly` (`id`, `target_id`, `month`, `real_qty`, `real_quality`, `is_active_print`) VALUES
(1, 1, 11, 30, 100, 1),
(2, 2, 11, 8, 100, 1),
(3, 3, 11, 8, 100, 1),
(4, 4, 11, 4, 67, 1),
(5, 5, 11, 1, 100, 1),
(6, 6, 11, 2, 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pkp_signatures`
--

CREATE TABLE `pkp_signatures` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year_id` int(11) NOT NULL,
  `appraiser_name` varchar(100) DEFAULT NULL,
  `appraiser_nip` varchar(50) DEFAULT NULL,
  `appraiser_position` varchar(100) DEFAULT NULL,
  `atasan_appraiser_name` varchar(100) DEFAULT NULL,
  `atasan_appraiser_nip` varchar(50) DEFAULT NULL,
  `atasan_appraiser_position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pkp_signatures`
--

INSERT INTO `pkp_signatures` (`id`, `user_id`, `month`, `year_id`, `appraiser_name`, `appraiser_nip`, `appraiser_position`, `atasan_appraiser_name`, `atasan_appraiser_nip`, `atasan_appraiser_position`) VALUES
(1, 2, 11, 1, 'Sutrisno Rivai, S.E., M.H.', '198301122011011003', 'Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pkp_targets`
--

CREATE TABLE `pkp_targets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `indicator_id` int(11) NOT NULL,
  `activity_name` text NOT NULL,
  `target_period` enum('Bulanan','Triwulan','Tahunan') NOT NULL DEFAULT 'Bulanan',
  `target_qty` int(11) NOT NULL,
  `target_quality` int(11) DEFAULT 100,
  `target_unit` varchar(50) NOT NULL,
  `target_credit_score` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pkp_targets`
--

INSERT INTO `pkp_targets` (`id`, `user_id`, `year_id`, `indicator_id`, `activity_name`, `target_period`, `target_qty`, `target_quality`, `target_unit`, `target_credit_score`) VALUES
(1, 2, 1, 1, 'Terlaksananya pengelolaan media sosial', 'Bulanan', 360, 100, 'Kegiatan', 0),
(2, 2, 1, 1, 'Terlaksananya pemeliharaan jaringan', 'Bulanan', 96, 100, 'Kegiatan', 0),
(3, 2, 1, 1, 'Terlaksananya pemeliharaan PC/laptop', 'Bulanan', 96, 100, 'Kegiatan', 0),
(4, 2, 1, 1, 'Terlaksananya pemeliharaan printer dan scanner', 'Bulanan', 72, 100, 'Kegiatan', 0),
(5, 2, 1, 1, 'Terlaksananya pengembangan sistem informasi yang mendukung optimalisasi kinerja instansi', 'Tahunan', 1, 100, 'Kegiatan', 0),
(6, 2, 1, 1, 'Terlaksananya persiapan dan monitoring peralatan video conference, termasuk audio, video, jaringan, serta pengaturan layout', 'Bulanan', 36, 100, 'Kegiatan', 0),
(7, 2, 1, 2, 'Terlaksananya Penilaian Pendahuluan Zona Integritas', 'Tahunan', 1, 100, 'Dokumen', 0),
(8, 2, 1, 2, 'Terlaksananya laporan tindak lanjut hasil pengawasan bidang dan pengawasan daerah', 'Triwulan', 8, 100, 'Dokumen', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_positions`
--

CREATE TABLE `ref_positions` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_positions`
--

INSERT INTO `ref_positions` (`id`, `position_name`) VALUES
(1, 'Pranata Komputer Ahli Pertama');

-- --------------------------------------------------------

--
-- Table structure for table `ref_ranks`
--

CREATE TABLE `ref_ranks` (
  `id` int(11) NOT NULL,
  `rank_name` varchar(100) NOT NULL,
  `golongan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_ranks`
--

INSERT INTO `ref_ranks` (`id`, `rank_name`, `golongan`) VALUES
(1, 'Juru Muda', 'I/a'),
(2, 'Juru Muda Tingkat I', 'I/b'),
(3, 'Juru', 'I/c'),
(4, 'Juru Tingkat I', 'I/d'),
(5, 'Pengatur Muda', 'II/a'),
(6, 'Pengatur Muda Tingkat I', 'II/b'),
(7, 'Pengatur', 'II/c'),
(8, 'Pengatur Tingkat I', 'II/d'),
(9, 'Penata Muda', 'III/a'),
(10, 'Penata Muda Tingkat I', 'III/b'),
(11, 'Penata', 'III/c'),
(12, 'Penata Tingkat I', 'III/d'),
(13, 'Pembina', 'IV/a'),
(14, 'Pembina Tingkat I', 'IV/b'),
(15, 'Pembina Utama Muda', 'IV/c'),
(16, 'Pembina Utama Madya', 'IV/d'),
(17, 'Pembina Utama', 'IV/e');

-- --------------------------------------------------------

--
-- Table structure for table `ref_units`
--

CREATE TABLE `ref_units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_units`
--

INSERT INTO `ref_units` (`id`, `name`) VALUES
(1, 'Pengadilan Agama Gorontalo');

-- --------------------------------------------------------

--
-- Table structure for table `ref_years`
--

CREATE TABLE `ref_years` (
  `id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_years`
--

INSERT INTO `ref_years` (`id`, `year`, `is_active`) VALUES
(1, 2025, 1),
(2, 2026, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL DEFAULT 'pegawai',
  `unit_id` int(11) DEFAULT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nip`, `password`, `full_name`, `role`, `unit_id`, `rank_id`, `position_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$1f50rLSpywu18BwuMxSvbOAkw7MOUIck4r2Heb1Cf5cV1a5hRz7jm', 'Administrator', 'admin', NULL, NULL, NULL, '2025-12-01 06:22:06'),
(2, '199510212020121004', '$2y$10$0xcCOUNSpz282R1kZH3AGOHy.uUkTx6FW7F2xS3Yx6l47K2W/kXnW', 'Rahmat Triadi, S.Kom.', 'pegawai', 1, 9, 1, '2025-12-01 07:04:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pkp_indicators`
--
ALTER TABLE `pkp_indicators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkp_monthly`
--
ALTER TABLE `pkp_monthly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkp_signatures`
--
ALTER TABLE `pkp_signatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkp_targets`
--
ALTER TABLE `pkp_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_positions`
--
ALTER TABLE `ref_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_ranks`
--
ALTER TABLE `ref_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_units`
--
ALTER TABLE `ref_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_years`
--
ALTER TABLE `ref_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pkp_indicators`
--
ALTER TABLE `pkp_indicators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pkp_monthly`
--
ALTER TABLE `pkp_monthly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pkp_signatures`
--
ALTER TABLE `pkp_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pkp_targets`
--
ALTER TABLE `pkp_targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ref_positions`
--
ALTER TABLE `ref_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ref_ranks`
--
ALTER TABLE `ref_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ref_units`
--
ALTER TABLE `ref_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ref_years`
--
ALTER TABLE `ref_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
