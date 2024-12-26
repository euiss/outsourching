<?php
require_once 'admin/config/database.php';

try {
    $id_lowongan = $_GET['id'];
    
    // Query untuk mengambil detail lowongan
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
        throw new Exception("Lowongan tidak ditemukan");
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: jobs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($job['jabatan']) ?> - Detail Lowongan</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .job-detail-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .job-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 10px;
        }

        .job-title {
            flex-grow: 1;
        }

        .job-title h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 18px;
            color: #666;
        }

        .job-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item i {
            color: #6c5ce7;
            font-size: 20px;
        }

        .job-description {
            margin-bottom: 30px;
        }

        .requirements {
            margin-bottom: 30px;
        }

        .requirements ul {
            list-style-type: none;
            padding-left: 0;
        }

        .requirements li {
            padding: 8px 0;
            position: relative;
            padding-left: 0;
            margin-bottom: 5px;
        }

        .requirements li:before {
            content: "";
        }

        .apply-button {
            display: inline-block;
            background: #6c5ce7;
            color: white;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .apply-button:hover {
            background: #5b4dd0;
        }

        @media (max-width: 768px) {
            .job-header {
                flex-direction: column;
                text-align: center;
            }

            .job-info {
                grid-template-columns: 1fr;
            }
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
            <a href="jobslog.php" class="nav-link active">All Jobs</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <a href="profile.php" class="user-name">
                        <i class="fas fa-user"></i>
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </a>
            <?php endif; ?>
                    <a href="my-applications.php" class="nav-link">My Applications</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
        </div>
    </nav>

    <div class="job-detail-container">
        <div class="job-header">
            <img src="admin/uploads/logos/<?= $job['logo'] ?: 'default-logo.png' ?>" alt="<?= htmlspecialchars($job['client_name']) ?>" class="company-logo">
            <div class="job-title">
                <h1><?= htmlspecialchars($job['jabatan']) ?></h1>
                <div class="company-name"><?= htmlspecialchars($job['client_name']) ?></div>
            </div>
        </div>

        <div class="job-info">
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><?= htmlspecialchars($job['lokasi']) ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-money-bill-wave"></i>
                <span>IDR <?= htmlspecialchars($job['gaji']) ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-users"></i>
                <span>Dibutuhkan: <?= htmlspecialchars($job['kebutuhan']) ?> orang</span>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>Deadline: <?= date('d M Y', strtotime($job['berakhir'])) ?></span>
            </div>
        </div>

        <div class="requirements">
            <h2>Persyaratan</h2>
            <ul>
                <?php 
                $syaratArray = explode("\n", $job['syarat']);
                foreach($syaratArray as $syarat): 
                    if(trim($syarat) !== ''): 
                ?>
                    <li><?= htmlspecialchars(trim($syarat)) ?></li>
                <?php 
                    endif;
                endforeach; 
                ?>
            </ul>
        </div>

        <div class="text-center">
            <a href="apply.php?id=<?php echo $job['id_lowongan']; ?>" class="apply-button">
                <i class="fas fa-paper-plane"></i> Apply Now
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <div class="footer-links">
                <h4>Support</h4>
                <a href="#">FAQ</a>
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