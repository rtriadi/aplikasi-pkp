-- Backup generated on 2026-02-02 14:39:20
-- Database: db_epkp

SET FOREIGN_KEY_CHECKS = 0;

-- Table structure for table `pkp_indicators`
DROP TABLE IF EXISTS `pkp_indicators`;
CREATE TABLE `pkp_indicators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `indicator_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `pkp_indicators`
INSERT INTO `pkp_indicators` VALUES ('1','2','1','TEKNOLOGI INFORMASI TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('2','2','1','DOKUMEN PELAPORAN TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('3','2','2','TEKNOLOGI INFORMASI TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('4','2','2','DOKUMEN PELAPORAN TERKELOLA DENGAN BAIK DAN AKUNTABEL');

-- Table structure for table `pkp_monthly`
DROP TABLE IF EXISTS `pkp_monthly`;
CREATE TABLE `pkp_monthly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `real_qty` int(11) DEFAULT 0,
  `real_quality` int(11) DEFAULT 0,
  `is_active_print` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_monthly`
INSERT INTO `pkp_monthly` VALUES ('1','1','11','30','100','1'),('2','2','11','8','100','1'),('3','3','11','8','100','1'),('4','4','11','4','67','1'),('5','5','11','1','100','1'),('6','6','11','2','67','1'),('7','9','1','30','100','1'),('8','10','1','8','100','1'),('9','11','1','8','100','1'),('10','12','1','6','100','1'),('11','14','1','2','67','1');

-- Table structure for table `pkp_signatures`
DROP TABLE IF EXISTS `pkp_signatures`;
CREATE TABLE `pkp_signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year_id` int(11) NOT NULL,
  `appraiser_name` varchar(100) DEFAULT NULL,
  `appraiser_nip` varchar(50) DEFAULT NULL,
  `appraiser_position` varchar(100) DEFAULT NULL,
  `atasan_appraiser_name` varchar(100) DEFAULT NULL,
  `atasan_appraiser_nip` varchar(50) DEFAULT NULL,
  `atasan_appraiser_position` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_signatures`
INSERT INTO `pkp_signatures` VALUES ('1','2','11','1','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','',''),('2','2','1','2','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','','');

-- Table structure for table `pkp_targets`
DROP TABLE IF EXISTS `pkp_targets`;
CREATE TABLE `pkp_targets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `indicator_id` int(11) NOT NULL,
  `activity_name` text NOT NULL,
  `target_period` enum('Bulanan','Triwulan','Tahunan') NOT NULL DEFAULT 'Bulanan',
  `target_qty` int(11) NOT NULL,
  `target_quality` int(11) DEFAULT 100,
  `target_unit` varchar(50) NOT NULL,
  `target_credit_score` float DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_targets`
INSERT INTO `pkp_targets` VALUES ('1','2','1','1','Terlaksananya pengelolaan media sosial','Bulanan','360','100','Kegiatan','0'),('2','2','1','1','Terlaksananya pemeliharaan jaringan','Bulanan','96','100','Kegiatan','0'),('3','2','1','1','Terlaksananya pemeliharaan PC/laptop','Bulanan','96','100','Kegiatan','0'),('4','2','1','1','Terlaksananya pemeliharaan printer dan scanner','Bulanan','72','100','Kegiatan','0'),('5','2','1','1','Terlaksananya pengembangan sistem informasi yang mendukung optimalisasi kinerja instansi','Tahunan','1','100','Kegiatan','0'),('6','2','1','1','Terlaksananya persiapan dan monitoring peralatan video conference, termasuk audio, video, jaringan, serta pengaturan layout','Bulanan','36','100','Kegiatan','0'),('7','2','1','2','Terlaksananya Penilaian Pendahuluan Zona Integritas','Tahunan','1','100','Dokumen','0'),('8','2','1','2','Terlaksananya laporan tindak lanjut hasil pengawasan bidang dan pengawasan daerah','Triwulan','8','100','Dokumen','0'),('9','2','2','3','Terlaksananya pengelolaan media sosial','Bulanan','360','100','Kegiatan','0'),('10','2','2','3','Terlaksananya pemeliharaan jaringan','Bulanan','96','100','Kegiatan','0'),('11','2','2','3','Terlaksananya pemeliharaan PC/laptop','Bulanan','96','100','Kegiatan','0'),('12','2','2','3','Terlaksananya pemeliharaan printer dan scanner','Bulanan','72','100','Kegiatan','0'),('13','2','2','3','Terlaksananya pengembangan sistem informasi yang mendukung optimalisasi kinerja instansi','Tahunan','1','100','Kegiatan','0'),('14','2','2','3','Terlaksananya persiapan dan monitoring peralatan video conference, termasuk audio, video, jaringan, serta pengaturan layout','Bulanan','36','100','Kegiatan','0'),('15','2','2','4','Terlaksananya Penilaian Pendahuluan Zona Integritas','Tahunan','1','100','Kegiatan','0'),('16','2','2','4','Terlaksananya laporan tindak lanjut hasil pengawasan bidang dan pengawasan daerah','Triwulan','8','100','Dokumen','0');

-- Table structure for table `ref_positions`
DROP TABLE IF EXISTS `ref_positions`;
CREATE TABLE `ref_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table `ref_positions`
INSERT INTO `ref_positions` VALUES ('1','Pranata Komputer Ahli Pertama');

-- Table structure for table `ref_ranks`
DROP TABLE IF EXISTS `ref_ranks`;
CREATE TABLE `ref_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(100) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table `ref_ranks`
INSERT INTO `ref_ranks` VALUES ('1','Juru Muda','I/a'),('2','Juru Muda Tingkat I','I/b'),('3','Juru','I/c'),('4','Juru Tingkat I','I/d'),('5','Pengatur Muda','II/a'),('6','Pengatur Muda Tingkat I','II/b'),('7','Pengatur','II/c'),('8','Pengatur Tingkat I','II/d'),('9','Penata Muda','III/a'),('10','Penata Muda Tingkat I','III/b'),('11','Penata','III/c'),('12','Penata Tingkat I','III/d'),('13','Pembina','IV/a'),('14','Pembina Tingkat I','IV/b'),('15','Pembina Utama Muda','IV/c'),('16','Pembina Utama Madya','IV/d'),('17','Pembina Utama','IV/e');

-- Table structure for table `ref_units`
DROP TABLE IF EXISTS `ref_units`;
CREATE TABLE `ref_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table `ref_units`
INSERT INTO `ref_units` VALUES ('1','Pengadilan Agama Gorontalo');

-- Table structure for table `ref_years`
DROP TABLE IF EXISTS `ref_years`;
CREATE TABLE `ref_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table `ref_years`
INSERT INTO `ref_years` VALUES ('1','2025','0'),('2','2026','1');

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL DEFAULT 'pegawai',
  `unit_id` int(11) DEFAULT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table `users`
INSERT INTO `users` VALUES ('1','admin','$2y$10$1f50rLSpywu18BwuMxSvbOAkw7MOUIck4r2Heb1Cf5cV1a5hRz7jm','Administrator','admin',NULL,NULL,NULL,'2025-12-01 14:22:06'),('2','199510212020121004','$2y$10$0xcCOUNSpz282R1kZH3AGOHy.uUkTx6FW7F2xS3Yx6l47K2W/kXnW','Rahmat Triadi, S.Kom.','pegawai','1','9','1','2025-12-01 15:04:28');

SET FOREIGN_KEY_CHECKS = 1;
