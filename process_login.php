<?php
require_once 'admin/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Escape string untuk mencegah SQL injection
        $email = mysqli_real_escape_string($conn, $email);
        
        // Query untuk mencari user
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verifikasi password langsung (tanpa hashing untuk sementara)
            if ($password === $user['password']) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['user_name'] = $user['nama_user'];
                $_SESSION['user_email'] = $user['email'];

                // Redirect ke halaman admin jika login berhasil
                header("Location: indexlog.php");
                exit();
            } else {
                $_SESSION['error'] = "Email atau password salah!";
            }
        } else {
            $_SESSION['error'] = "Email atau password salah!";
        }
        
        header("Location: login.php");
        exit();

    } catch(Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?> 