-- 1. Buat dan Pilih Database
CREATE DATABASE IF NOT EXISTS buypanen;
USE buypanen;

-- 2. Hapus Tabel Lama (Mencegah bentrok jika pernah di-run separuh)
DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS petani;
DROP TABLE IF EXISTS users;

-- =================================
-- TABEL USERS
-- =================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('petani', 'admin') NOT NULL DEFAULT 'petani',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =================================
-- TABEL PETANI
-- =================================
CREATE TABLE petani (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    no_whatsapp VARCHAR(20) NOT NULL,
    lokasi_kebun TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =================================
-- TABEL KATEGORI
-- =================================
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL UNIQUE,
    deskripsi TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =================================
-- TABEL PRODUK
-- =================================
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    kategori_id INT NOT NULL,
    nama_produk VARCHAR(150) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    satuan VARCHAR(30) NOT NULL DEFAULT 'kg',
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    foto VARCHAR(255),
    status ENUM('tayang', 'disembunyikan') NOT NULL DEFAULT 'tayang',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_produk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_produk_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =================================
-- DATA KATEGORI AWAL
-- =================================
INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Sayur', 'Berbagai jenis hasil panen sayuran'),
('Buah', 'Berbagai jenis hasil panen buah'),
('Pangan', 'Berbagai jenis hasil panen pangan');