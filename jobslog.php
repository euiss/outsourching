<?php
require_once 'admin/config/database.php';
session_start();

try {
    // Query untuk mengambil data lowongan yang aktif
    $query = "SELECT l.*, c.client_name, c.logo 
             FROM lowongan l
             LEFT JOIN client c ON l.id_client = c.id_client
             WHERE l.status = 'Active'
             ORDER BY l.mulai DESC";
             
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lowongan Tersedia - Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-links a {
            text-decoration: none !important;
            color: #333;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #6c5ce7;
            text-decoration: none;
        }

        .nav-links .active {
            color: #6c5ce7;
            font-weight: bold;
        }

        .jobs-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .job-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
        }

        .company-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .job-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .job-title a:hover {
            color: #6c5ce7;
        }

        .job-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .job-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .company-name {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .job-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .detail-item i {
            width: 16px;
            color: #2557a7;
        }

        .apply-btn {
            width: 100%;
            padding: 12px;
            background: #2557a7;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .apply-btn:hover {
            background: #1d4ed8;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #666;
            font-size: 16px;
        }

        .no-jobs {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 16px;
        }

        .job-title a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
            text-decoration: none !important;
        }

        .job-title a:hover {
            color: #6c5ce7;
            text-decoration: none;
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
                    <a href="my-applications.php" class="nav-link">My Applications</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Jobs Header -->
    <header class="jobs-header"><br>
        <h1 align="center">Available Positions</h1>
    </header>

        <div class="jobs-grid">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($job = mysqli_fetch_assoc($result)): ?>
                    <div class="job-card">
                        <img src="admin/uploads/logos/<?php echo $job['logo'] ?: 'default-logo.png'; ?>" 
                             alt="<?php echo htmlspecialchars($job['client_name']); ?>" 
                             class="company-logo">
                        
                        <h3 class="job-title">
                            <a href="job-detaillog.php?id=<?php echo htmlspecialchars($job['id_lowongan']); ?>">
                                <?php echo htmlspecialchars($job['jabatan']); ?>
                            </a>
                        </h3>
                        <p class="company-name"><?php echo htmlspecialchars($job['client_name']); ?></p>
                        
                        <div class="job-details">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($job['lokasi']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>IDR <?php echo htmlspecialchars($job['gaji']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-users"></i>
                                <span>Dibutuhkan: <?php echo htmlspecialchars($job['kebutuhan']); ?> orang</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>Deadline: <?php echo date('d M Y', strtotime($job['berakhir'])); ?></span>
                            </div>
                        </div>

                        <a href="apply.php?id=<?php echo $job['id_lowongan']; ?>" class="apply-btn">
                            Apply Now
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-jobs">
                    <p>Tidak ada lowongan yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
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