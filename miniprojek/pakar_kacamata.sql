CREATE DATABASE pakar_kacamata;
USE pakar_kacamata;


-- ======================
-- TABEL CONDITIONS
-- ======================
CREATE TABLE conditions (
    id_condition INT AUTO_INCREMENT PRIMARY KEY,
    condition_code VARCHAR(10) UNIQUE,
    category VARCHAR(50),
    condition_name VARCHAR(100),
    description TEXT
);

INSERT INTO `conditions` (`id_condition`, `condition_code`, `category`, `condition_name`, `description`) VALUES
(1, 'AGE01', 'usia', 'Anak-anak', 'Usia anak atau remaja'),
(2, 'AGE02', 'usia', 'Dewasa', 'Usia produktif dewasa'),
(3, 'AGE03', 'usia', 'Di atas 40 tahun', 'Kategori presbyopia'),
(4, 'VIS01', 'keluhan', 'Penglihatan jauh kabur', 'Kesulitan melihat objek jauh'),
(5, 'VIS02', 'keluhan', 'Sulit membaca jarak dekat', 'Kesulitan membaca tulisan kecil'),
(6, 'VIS03', 'keluhan', 'Mata cepat lelah', 'Mata terasa lelah'),
(7, 'VIS04', 'keluhan', 'Mata sering merah', 'Mata mudah iritasi'),
(8, 'VIS05', 'keluhan', 'Silau saat malam', 'Sensitif cahaya saat malam'),
(9, 'VIS06', 'keluhan', 'Mata sensitif cahaya', 'Mudah silau'),
(10, 'ACT01', 'aktivitas', 'Sering di depan layar', 'Laptop, komputer, gadget'),
(11, 'ACT02', 'aktivitas', 'Sering menyetir malam', 'Berkendara malam'),
(12, 'ACT03', 'aktivitas', 'Aktivitas outdoor', 'Sering di luar ruangan'),
(13, 'ACT04', 'aktivitas', 'Sering olahraga', 'Aktivitas fisik'),
(14, 'ACT05', 'aktivitas', 'Sering di ruangan AC', 'Lingkungan AC'),
(15, 'NEED01', 'kebutuhan', 'Untuk kerja atau kuliah', 'Produktivitas'),
(16, 'NEED02', 'kebutuhan', 'Untuk berkendara', 'Transportasi'),
(17, 'NEED03', 'kebutuhan', 'Untuk aktivitas outdoor', 'Aktivitas luar'),
(18, 'NEED04', 'kebutuhan', 'Untuk sehari-hari', 'Penggunaan umum');

-- --------------------------------------------------------



DROP TABLE IF EXISTS `frame_kacamata`;
CREATE TABLE IF NOT EXISTS `frame_kacamata` (
  `id_frame` int NOT NULL AUTO_INCREMENT,
  `nama_frame` varchar(100) DEFAULT NULL,
  `bahan` varchar(50) DEFAULT NULL,
  `id_recommendation` int DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_frame`),
  KEY `id_recommendation` (`id_recommendation`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `frame_kacamata` (`id_frame`, `nama_frame`, `bahan`, `id_recommendation`, `deskripsi`) VALUES
(1, 'Sporty TR90', 'Plastik TR90', 4, 'Frame lentur dan tahan banting, cocok untuk lensa Polycarbonate.'),
(2, 'Frame Titanium Sport', NULL, 2, 'Sangat ringan dan kuat untuk aktivitas luar ruangan.'),
(3, 'Frame Acetate Bulat', NULL, 1, 'Gaya klasik yang cocok untuk lensa Blue Ray.');

-- --------------------------------------------------------


DROP TABLE IF EXISTS `history_diagnosa`;
CREATE TABLE IF NOT EXISTS `history_diagnosa` (
  `id_history` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_recommendation` int DEFAULT NULL,
  `hasil_skor` float DEFAULT NULL,
  PRIMARY KEY (`id_history`),
  KEY `id_recommendation` (`id_recommendation`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `history_diagnosa` (`id_history`, `nama_user`, `tanggal`, `id_recommendation`, `hasil_skor`) VALUES
(1, 'Guest User', '2026-05-12 00:40:22', 3, 1),
(2, 'Guest User', '2026-05-12 00:53:24', 3, 1),
(3, 'Guest User', '2026-05-12 00:53:52', 2, 1),
(4, 'Guest User', '2026-05-12 00:57:23', 2, 1),
(5, 'Guest User', '2026-05-12 01:02:03', 2, 1);



DROP TABLE IF EXISTS `recommendations`;
CREATE TABLE IF NOT EXISTS `recommendations` (
  `id_recommendation` int NOT NULL AUTO_INCREMENT,
  `lens_name` varchar(100) DEFAULT NULL,
  `lens_category` varchar(50) DEFAULT NULL,
  `description` text,
  `reasoning` text,
  PRIMARY KEY (`id_recommendation`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `recommendations` (`id_recommendation`, `lens_name`, `lens_category`, `description`, `reasoning`) VALUES
(1, 'Blue Ray Lens', 'Digital Protection', 'Lensa pelindung sinar biru', 'Mengurangi paparan layar'),
(2, 'Photochromic Lens', 'Outdoor Protection', 'Lensa berubah gelap saat UV', 'Cocok outdoor'),
(3, 'Progressive Lens', 'Multifocal', 'Lensa multifokus', 'Cocok usia 40+'),
(4, 'Polycarbonate Lens', 'Safety Lens', 'Lensa tahan benturan', 'Cocok olahraga'),
(5, 'Anti-Glare Lens', 'Night Vision', 'Mengurangi silau malam', 'Cocok berkendara malam'),
(6, 'Standard Lens', 'Standard', 'Lensa standar', 'Penggunaan umum');



DROP TABLE IF EXISTS `rules`;
CREATE TABLE IF NOT EXISTS `rules` (
  `id_rule` int NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(100) DEFAULT NULL,
  `id_recommendation` int DEFAULT NULL,
  `confidence_weight` int DEFAULT NULL,
  `reasoning_rule` text,
  PRIMARY KEY (`id_rule`),
  KEY `id_recommendation` (`id_recommendation`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `rules` (`id_rule`, `rule_name`, `id_recommendation`, `confidence_weight`, `reasoning_rule`) VALUES
(1, 'Rule Blue Ray', 1, 90, 'Paparan layar menyebabkan mata lelah'),
(2, 'Rule Photochromic', 2, 85, 'Outdoor butuh proteksi UV'),
(3, 'Rule Progressive', 3, 95, 'Usia 40+ sulit melihat dekat'),
(4, 'Rule Polycarbonate', 4, 80, 'Olahraga butuh lensa aman'),
(5, 'Rule Anti Glare', 5, 88, 'Menyetir malam butuh anti silau');


DROP TABLE IF EXISTS `rule_details`;
CREATE TABLE IF NOT EXISTS `rule_details` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_rule` int DEFAULT NULL,
  `id_condition` int DEFAULT NULL,
  `weight_score` int DEFAULT NULL,
  `mb` float DEFAULT '0',
  `md` float DEFAULT '0',
  PRIMARY KEY (`id_detail`),
  KEY `id_rule` (`id_rule`),
  KEY `id_condition` (`id_condition`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `rule_details` (`id_detail`, `id_rule`, `id_condition`, `weight_score`, `mb`, `md`) VALUES
(1, 1, 6, 40, 0, 0),
(2, 1, 10, 40, 0, 0),
(3, 2, 9, 35, 0, 0),
(4, 2, 12, 40, 0, 0),
(5, 3, 3, 40, 0, 0),
(6, 3, 5, 40, 0, 0),
(7, 4, 13, 70, 0, 0),
(8, 5, 8, 50, 0, 0);




DROP TABLE IF EXISTS `tips_kesehatan`;
CREATE TABLE IF NOT EXISTS `tips_kesehatan` (
  `id_tips` int NOT NULL AUTO_INCREMENT,
  `id_recommendation` int DEFAULT NULL,
  `judul_artikel` varchar(255) DEFAULT NULL,
  `isi_artikel` text,
  PRIMARY KEY (`id_tips`),
  KEY `id_recommendation` (`id_recommendation`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `tips_kesehatan` (`id_tips`, `id_recommendation`, `judul_artikel`, `isi_artikel`) VALUES
(1, 1, 'Tips Proteksi Mata Radiasi', 'Gunakan aturan 20-20-20 saat menatap layar...'),
(2, 1, NULL, 'Gunakan aturan 20-20-20: Setiap 20 menit, lihat benda berjarak 20 kaki selama 20 detik.'),
(3, 2, NULL, 'Pastikan lensa dibersihkan dengan kain microfiber agar lapisan anti-UV tidak tergores.');
COMMIT;
