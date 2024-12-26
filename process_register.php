<?php
require_once 'admin/config/database.php';

// Pastikan koneksi database sudah dibuat
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("<script>
        alert('Koneksi Database gagal: " . mysqli_connect_error() . "');
        window.location.href='register.html';
    </script>");
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mengambil data dari form
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $date = date('Y-m-d');
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Generate ID User (format: USR + YYYYMMDD + 3 digit random number)
        $randomNum = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $id_user = 'USR' . date('Ymd') . $randomNum;
        
        // Cek apakah email sudah terdaftar
        $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        
        if (mysqli_num_rows($check_email) > 0) {
            echo "<script>
                alert('Email sudah terdaftar!');
                window.location.href='register.html';
            </script>";
            exit();
        }

        // Query untuk menyimpan data user baru
        $sql = "INSERT INTO user (id_user, nama_user, email, password, tanggal_daftar) 
                VALUES ('$id_user', '$fullname', '$email', '$password', '$date')";
                
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href='login.php';
            </script>";
        } else {
            echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location.href='register.php';
            </script>";
        }
    }
} catch(Exception $e) {
    echo "<script>
        alert('Terjadi kesalahan: " . addslashes($e->getMessage()) . "');
        window.location.href='register.php';
    </script>";
} finally {
    mysqli_close($conn);
}
?> 