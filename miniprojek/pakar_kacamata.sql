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

INSERT INTO conditions 
(condition_code, category, condition_name, description)
VALUES
('AGE01', 'usia', 'Anak-anak', 'Usia anak atau remaja'),
('AGE02', 'usia', 'Dewasa', 'Usia produktif dewasa'),
('AGE03', 'usia', 'Di atas 40 tahun', 'Kategori presbyopia'),
('VIS01', 'keluhan', 'Penglihatan jauh kabur', 'Kesulitan melihat objek jauh'),
('VIS02', 'keluhan', 'Sulit membaca jarak dekat', 'Kesulitan membaca tulisan kecil'),
('VIS03', 'keluhan', 'Mata cepat lelah', 'Mata terasa lelah'),
('VIS04', 'keluhan', 'Mata sering merah', 'Mata mudah iritasi'),
('VIS05', 'keluhan', 'Silau saat malam', 'Sensitif cahaya saat malam'),
('VIS06', 'keluhan', 'Mata sensitif cahaya', 'Mudah silau'),
('ACT01', 'aktivitas', 'Sering di depan layar', 'Laptop, komputer, gadget'),
('ACT02', 'aktivitas', 'Sering menyetir malam', 'Berkendara malam'),
('ACT03', 'aktivitas', 'Aktivitas outdoor', 'Sering di luar ruangan'),
('ACT04', 'aktivitas', 'Sering olahraga', 'Aktivitas fisik'),
('ACT05', 'aktivitas', 'Sering di ruangan AC', 'Lingkungan AC'),
('NEED01', 'kebutuhan', 'Untuk kerja atau kuliah', 'Produktivitas'),
('NEED02', 'kebutuhan', 'Untuk berkendara', 'Transportasi'),
('NEED03', 'kebutuhan', 'Untuk aktivitas outdoor', 'Aktivitas luar'),
('NEED04', 'kebutuhan', 'Untuk sehari-hari', 'Penggunaan umum');


-- ======================
-- TABEL RECOMMENDATIONS
-- ======================
CREATE TABLE recommendations (
    id_recommendation INT AUTO_INCREMENT PRIMARY KEY,
    lens_name VARCHAR(100),
    lens_category VARCHAR(50),
    description TEXT,
    reasoning TEXT
);

INSERT INTO recommendations
(lens_name, lens_category, description, reasoning)
VALUES
('Blue Ray Lens', 'Digital Protection', 'Lensa pelindung sinar biru', 'Mengurangi paparan layar'),
('Photochromic Lens', 'Outdoor Protection', 'Lensa berubah gelap saat UV', 'Cocok outdoor'),
('Progressive Lens', 'Multifocal', 'Lensa multifokus', 'Cocok usia 40+'),
('Polycarbonate Lens', 'Safety Lens', 'Lensa tahan benturan', 'Cocok olahraga'),
('Anti-Glare Lens', 'Night Vision', 'Mengurangi silau malam', 'Cocok berkendara malam'),
('Standard Lens', 'Standard', 'Lensa standar', 'Penggunaan umum');


-- ======================
-- TABEL RULES
-- ======================
CREATE TABLE rules (
    id_rule INT AUTO_INCREMENT PRIMARY KEY,
    rule_name VARCHAR(100),
    id_recommendation INT,
    confidence_weight INT,
    reasoning_rule TEXT,
    FOREIGN KEY (id_recommendation) 
    REFERENCES recommendations(id_recommendation)
);

INSERT INTO rules
(rule_name, id_recommendation, confidence_weight, reasoning_rule)
VALUES
('Rule Blue Ray', 1, 90, 'Paparan layar menyebabkan mata lelah'),
('Rule Photochromic', 2, 85, 'Outdoor butuh proteksi UV'),
('Rule Progressive', 3, 95, 'Usia 40+ sulit melihat dekat'),
('Rule Polycarbonate', 4, 80, 'Olahraga butuh lensa aman'),
('Rule Anti Glare', 5, 88, 'Menyetir malam butuh anti silau');


-- ======================
-- TABEL RULE DETAILS
-- ======================
CREATE TABLE rule_details (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_rule INT,
    id_condition INT,
    weight_score INT,
    FOREIGN KEY (id_rule) 
    REFERENCES rules(id_rule),
    FOREIGN KEY (id_condition) 
    REFERENCES conditions(id_condition)
);

INSERT INTO rule_details
(id_rule, id_condition, weight_score)
VALUES
(1, 6, 40),
(1, 10, 40),
(2, 9, 35),
(2, 12, 40),
(3, 3, 40),
(3, 5, 40),
(4, 13, 70),
(5, 8, 50);
