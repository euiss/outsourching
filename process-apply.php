<?php
require_once 'admin/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validasi input
        if (!isset($_POST['id_user']) || !isset($_POST['id_lowongan'])) {
            throw new Exception("Data tidak lengkap");
        }

        $id_user = $_POST['id_user'];
        $id_lowongan = $_POST['id_lowongan'];
        $cover_letter = $_POST['cover_letter'];
        $tanggal_lamar = date('Y-m-d H:i:s');
        
        // Generate ID Lamaran
        $query_last_id = "SELECT id_lamaran FROM lamaran ORDER BY id_lamaran DESC LIMIT 1";
        $result = mysqli_query($conn, $query_last_id);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $last_number = intval(substr($row['id_lamaran'], 3));
            $new_number = $last_number + 1;
            $id_lamaran = 'LMR' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        } else {
            $id_lamaran = 'LMR0001';
        }
        
        // Handle CV upload
        if (!isset($_FILES['cv'])) {
            throw new Exception("File CV tidak ditemukan");
        }

        if ($_FILES['cv']['error'] !== 0) {
            throw new Exception("Error saat upload file: " . $_FILES['cv']['error']);
        }

        $cv = $_FILES['cv'];
        $allowed = ['pdf'];
        $filename = $cv['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Validasi tipe file
        if (!in_array($filetype, $allowed)) {
            throw new Exception('Format file tidak diizinkan. Gunakan PDF.');
        }
        
        // Validasi ukuran file (2MB)
        if ($cv['size'] > 2000000) {
            throw new Exception('Ukuran file terlalu besar. Maksimal 2MB.');
        }
        
        // Generate nama file baru
        $newname = $id_user . '_' . $id_lowongan . '_' . time() . '.' . $filetype;
        $upload_path = 'admin/uploads/cv/' . $newname;
        
        // Buat direktori jika belum ada
        if (!file_exists('admin/uploads/cv/')) {
            mkdir('admin/uploads/cv/', 0777, true);
        }
        
        // Pindahkan file
        if (!move_uploaded_file($cv['tmp_name'], $upload_path)) {
            throw new Exception('Gagal mengupload file. Path: ' . $upload_path);
        }
        
        // Insert ke database
        $query = "INSERT INTO lamaran (id_lamaran, id_user, id_lowongan, cv, cover_letter, tanggal_lamar, status) 
                 VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ssssss", 
            $id_lamaran,
            $id_user,
            $id_lowongan,
            $newname,
            $cover_letter,
            $tanggal_lamar
        );
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing statement: " . mysqli_stmt_error($stmt));
        }

        $_SESSION['message'] = "Lamaran berhasil dikirim! Nomor lamaran Anda: " . $id_lamaran;
        header("Location: my-applications.php");
        exit();
        
    } catch(Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        error_log("Apply Error: " . $e->getMessage());
        header("Location: apply.php?id=" . $id_lowongan);
        exit();
    }
} else {
    header("Location: jobslog.php");
    exit();
}
?> 