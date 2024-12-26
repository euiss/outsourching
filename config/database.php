<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'outsourching';

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset ke utf8
mysqli_set_charset($conn, "utf8");
?> 