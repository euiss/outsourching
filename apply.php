<?php
require_once 'admin/config/database.php';
session_start();

// Cek jika user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Cek jika ada ID lowongan
if (!isset($_GET['id'])) {
    header("Location: jobslog.php");
    exit();
}

$id_lowongan = $_GET['id'];

try {
    // Ambil detail lowongan
    $query = "SELECT l.*, c.client_name, c.logo 
             FROM lowongan l
             LEFT JOIN client c ON l.id_client = c.id_client
             WHERE l.id_lowongan = ? AND l.status = 'Active'";
             
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_lowongan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $job = mysqli_fetch_assoc($result);

    if (!$job) {
        $_SESSION['error'] = "Lowongan tidak ditemukan atau sudah tidak aktif.";
        header("Location: jobslog.php");
        exit();
    }

} catch(Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: jobslog.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply - <?php echo htmlspecialchars($job['jabatan']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .apply-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .job-header {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .job-info h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
        }

        .company-name {
            color: #2557a7;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .job-meta {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 14px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-item i {
            color: #2557a7;
        }

        .apply-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f9fa;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            background: #2557a7;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="indexlog.php">
                <img src="images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="nav-links">
            <a href="jobslog.php" class="nav-link">All Jobs</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <a href="profile.php" class="user-name">
                        <i class="fas fa-user"></i>
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
                    <a href="my-applications.php" class="nav-link">My Applications</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="apply-container">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="job-header">
            <img src="admin/uploads/logos/<?php echo $job['logo'] ?: 'default-logo.png'; ?>" 
                 alt="<?php echo htmlspecialchars($job['client_name']); ?>" 
                 class="company-logo">
            <div class="job-info">
                <h1><?php echo htmlspecialchars($job['jabatan']); ?></h1>
                <div class="company-name"><?php echo htmlspecialchars($job['client_name']); ?></div>
                <div class="job-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($job['lokasi']); ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>IDR <?php echo htmlspecialchars($job['gaji']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <form action="process-apply.php" method="POST" enctype="multipart/form-data" class="apply-form">
            <input type="hidden" name="id_lowongan" value="<?php echo htmlspecialchars($id_lowongan); ?>">
            
            <div class="form-group">
                <label for="name">Nama Pelamar</label>
                <input id="user_name" name="user_name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                <input type="hidden" id="id_user" name="id_user" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                <input type="hidden" id="id_lowongan" name="id_lowongan" value="<?php echo htmlspecialchars($job['id_lowongan']); ?>">
            </div>

            <div class="form-group">
                <label for="cv">Upload CV (PDF)</label>
                <input type="file" id="cv" name="cv" accept=".pdf" required>
                <small>Maksimal ukuran file: 2MB</small>
            </div>

            <div class="form-group">
                <label for="cover_letter">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" placeholder="Tuliskan cover letter Anda di sini..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Application</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <div class="footer-links">
                <h4>Support</h4>
                <a href="#">Frequently Asked Question (FAQ)</a>
                <a href="#">Keamanan</a>
            </div>
            <div class="footer-certificates">
                <img src="images/sgs.png" alt="SGS">
                <img src="images/kominfo.png" alt="Kominfo">
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2024 Talentics.<br>PT Semesta Integrasi Digital. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html> 