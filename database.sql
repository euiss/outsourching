CREATE DATABASE IF NOT EXISTS outsourcing_db;
USE outsourcing_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

CREATE TABLE IF NOT EXISTS lowongan (
    id_lowongan VARCHAR(20) PRIMARY KEY,
    id_client VARCHAR(20),
    jabatan VARCHAR(255) NOT NULL,
    gaji VARCHAR(100),
    lokasi VARCHAR(100),
    kebutuhan INT,
    mulai DATE,
    berakhir DATE,
    deskripsi TEXT,
    syarat TEXT,
    status ENUM('Active', 'Closed') DEFAULT 'Active',
    FOREIGN KEY (id_client) REFERENCES client(id_client)
); 

CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user VARCHAR(20),
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(50) NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES user(id_user)
); 