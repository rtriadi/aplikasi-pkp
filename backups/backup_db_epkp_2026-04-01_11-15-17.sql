-- Backup generated on 2026-04-01 11:15:17
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `pkp_indicators`
INSERT INTO `pkp_indicators` VALUES ('1','2','1','TEKNOLOGI INFORMASI TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('2','2','1','DOKUMEN PELAPORAN TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('3','2','2','TEKNOLOGI INFORMASI TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('4','2','2','DOKUMEN PELAPORAN TERKELOLA DENGAN BAIK DAN AKUNTABEL'),('5','3','2','Kebutuhan Administrasi Perkantoran Terpenuhi dengan Baik dan Tepat Waktu'),('6','3','2','Penerimaan Negara Bukan Pajak (PNBP) Terealisasi sesuai Target'),('7','3','2','Pengelolaan Persediaan Barang dan ATK');

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_monthly`
INSERT INTO `pkp_monthly` VALUES ('1','1','11','30','100','1'),('2','2','11','8','100','1'),('3','3','11','8','100','1'),('4','4','11','4','67','1'),('5','5','11','1','100','1'),('6','6','11','2','67','1'),('7','9','1','20','100','1'),('8','10','1','4','100','1'),('9','11','1','6','100','1'),('10','12','1','4','100','1'),('11','14','1','2','67','1'),('12','13','1','0','0','1'),('13','17','1','40','98','1'),('14','18','1','40','98','1'),('15','19','1','38','97','1'),('16','20','1','38','97','1'),('17','21','1','76','97','1'),('18','22','1','38','97','1'),('19','23','1','2','100','1'),('20','24','1','2','100','1'),('21','25','1','1','100','1'),('22','26','1','0','0','1'),('23','9','2','20','100','1'),('24','10','2','4','100','1'),('25','11','2','6','100','1'),('26','12','2','2','50','1'),('27','14','2','3','100','1'),('28','16','2','2','100','1'),('29','10','3','4','100','1'),('30','11','3','3','50','1'),('31','12','3','2','50','1'),('32','13','3','1','100','1'),('33','14','3','3','100','1'),('34','15','3','1','100','1'),('35','9','3','20','100','1');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_signatures`
INSERT INTO `pkp_signatures` VALUES ('1','2','11','1','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','',''),('2','2','1','2','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','',''),('3','3','1','2','Maryam Palilati, S.Kom.','198209112009122003','Kasubbag Umum dan Keuangan Pengadilan Agama Gorontalo','','',''),('4','2','2','2','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','',''),('5','2','3','2','Sutrisno Rivai, S.E., M.H.','198301122011011003','Kasubbag Perencanaan, TI dan Pelaporan Pengadilan Agama Gorontalo','','','');

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table `pkp_targets`
INSERT INTO `pkp_targets` VALUES ('1','2','1','1','Terlaksananya pengelolaan media sosial','Bulanan','360','100','Kegiatan','0'),('2','2','1','1','Terlaksananya pemeliharaan jaringan','Bulanan','96','100','Kegiatan','0'),('3','2','1','1','Terlaksananya pemeliharaan PC/laptop','Bulanan','96','100','Kegiatan','0'),('4','2','1','1','Terlaksananya pemeliharaan printer dan scanner','Bulanan','72','100','Kegiatan','0'),('5','2','1','1','Terlaksananya pengembangan sistem informasi yang mendukung optimalisasi kinerja instansi','Tahunan','1','100','Kegiatan','0'),('6','2','1','1','Terlaksananya persiapan dan monitoring peralatan video conference, termasuk audio, video, jaringan, serta pengaturan layout','Bulanan','36','100','Kegiatan','0'),('7','2','1','2','Terlaksananya Penilaian Pendahuluan Zona Integritas','Tahunan','1','100','Dokumen','0'),('8','2','1','2','Terlaksananya laporan tindak lanjut hasil pengawasan bidang dan pengawasan daerah','Triwulan','8','100','Dokumen','0'),('9','2','2','3','Terlaksananya pengelolaan media sosial','Bulanan','240','100','Kegiatan','0'),('10','2','2','3','Terlaksananya pemeliharaan jaringan','Bulanan','48','100','Kegiatan','0'),('11','2','2','3','Terlaksananya pemeliharaan PC/laptop','Bulanan','72','100','Kegiatan','0'),('12','2','2','3','Terlaksananya pemeliharaan printer dan scanner','Bulanan','48','100','Kegiatan','0'),('13','2','2','3','Terlaksananya pengembangan sistem informasi yang mendukung optimalisasi kinerja instansi','Tahunan','1','100','Kegiatan','0'),('14','2','2','3','Terlaksananya persiapan dan monitoring peralatan video conference, termasuk audio, video, jaringan, serta pengaturan layout','Bulanan','36','100','Kegiatan','0'),('15','2','2','4','Terlaksananya Penilaian Pendahuluan Zona Integritas','Tahunan','1','100','Kegiatan','0'),('16','2','2','4','Terlaksananya laporan tindak lanjut hasil pengawasan bidang dan pengawasan daerah','Triwulan','8','100','Dokumen','0'),('17','3','2','5','Melakukan kegiatan pengelolaan surat masuk yaitu menerima dan menginput surat masuk pada aplikasi DIA-SMK V2\r\n','Bulanan','492','100','Dokumen','0'),('18','3','2','5','Melakukan pengarsipan surat masuk dan keluar pada lemari arsip sesuai dengan jenis surat','Bulanan','492','100','Dokumen','0'),('19','3','2','6','Melakukan input data PNBP yang diperoleh dari aplikasi SIPP ke dalam aplikasi SIMARI sesuai kode akun','Bulanan','468','100','Transaksi','0'),('20','3','2','6','Melakukan penyetoran jumlah PNBP yang diterima','Bulanan','468','100','Transaksi','0'),('21','3','2','6','Mencetak Surat Bukti Bayar (SBS) dan bukti penerimaan negara dari aplikasi SIMARI\r\n','Bulanan','936','100','Dokumen','0'),('22','3','2','6','Menginput transaksi PNBP ke dalam aplikasi SAKTI\r\n','Bulanan','468','100','Transaksi','0'),('23','3','2','6','Membuat Berita Acara Rekonsiliasi (BAR) \r\n','Bulanan','24','100','Transaksi','0'),('24','3','2','6','Mencetak laporan pertanggungjawaban (LPJ) DIPA 01 dan 04 dari aplikasi SAKTI setiap bulan\r\n','Bulanan','24','100','Dokumen','0'),('25','3','2','6','Mengarsipkan dokumen yang telah dicetak (SBS, bukti penerimaan, LPJ, BAR dan dokumen lain) per bulan','Bulanan','12','100','Dokumen','0'),('26','3','2','7','Membuat Laporan Persediaan 01 dan 04 setiap semester','Tahunan','2','100','Dokumen','0');

-- Table structure for table `ref_positions`
DROP TABLE IF EXISTS `ref_positions`;
CREATE TABLE `ref_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table `ref_positions`
INSERT INTO `ref_positions` VALUES ('1','Pranata Komputer Ahli Pertama'),('2','Arsiparis Terampil');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table `users`
INSERT INTO `users` VALUES ('1','admin','$2y$10$1f50rLSpywu18BwuMxSvbOAkw7MOUIck4r2Heb1Cf5cV1a5hRz7jm','Administrator','admin',NULL,NULL,NULL,'2025-12-01 14:22:06'),('2','199510212020121004','$2y$10$d7JJTdKPuAtFiZwWvkoq3urWxEOKlCji.0tOCUedGZ/KK/L8ElNMO','Rahmat Triadi, S.Kom.','pegawai','1','10','1','2025-12-01 15:04:28'),('3','199711062020122007','$2y$10$gjfvW3izQ2XkgkoViFVhMORoOllNPjm2sMPaY4Kn9Jx6j5TwWnUTi','Aqza Noviardini Putri, A.Md.','pegawai','1','8','2','2026-02-04 11:05:20');

SET FOREIGN_KEY_CHECKS = 1;
