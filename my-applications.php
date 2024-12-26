<?php
require_once 'admin/config/database.php';
session_start();

// Cek jika user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Query untuk mengambil data lamaran user
    $query = "SELECT l.*, j.jabatan, c.client_name, c.logo 
             FROM lamaran l
             LEFT JOIN lowongan j ON l.id_lowongan = j.id_lowongan
             LEFT JOIN client c ON j.id_client = c.id_client
             WHERE l.id_user = ?
             ORDER BY l.tanggal_lamar DESC";
             
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
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
    <title>My Applications - Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .applications-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .application-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            gap: 25px;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .application-info {
            flex: 1;
        }

        .job-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .company-name {
            color: #2557a7;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .application-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
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
            width: 16px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-accepted {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-interviewed {
            background: #cce5ff;
            color: #004085;
        }

        .application-actions {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            padding: 8px 16px;
            background: #2557a7;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .view-btn:hover {
            background: #1d4ed8;
        }

        .no-applications {
            text-align: center;
            padding: 40px;
            color: #666;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
                    <a href="my-applications.php" class="nav-link active">My Applications</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="applications-container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <h1>My Applications</h1>

        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($application = mysqli_fetch_assoc($result)): 
                $status_class = '';
                switch($application['status']) {
                    case 'Pending':
                        $status_class = 'status-pending';
                        break;
                    case 'Accepted':
                        $status_class = 'status-accepted';
                        break;
                    case 'Rejected':
                        $status_class = 'status-rejected';
                        break;
                    case 'Interviewed':
                        $status_class = 'status-interviewed';
                        break;
                }
            ?>
                <div class="application-card">
                    <img src="admin/uploads/logos/<?php echo $application['logo'] ?: 'default-logo.png'; ?>" 
                         alt="<?php echo htmlspecialchars($application['client_name']); ?>" 
                         class="company-logo">
                    
                    <div class="application-info">
                        <h2 class="job-title"><?php echo htmlspecialchars($application['jabatan']); ?></h2>
                        <div class="company-name"><?php echo htmlspecialchars($application['client_name']); ?></div>
                        
                        <div class="application-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>Applied: <?php echo date('d M Y', strtotime($application['tanggal_lamar'])); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-file-alt"></i>
                                <span>Application ID: <?php echo htmlspecialchars($application['id_lamaran']); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($application['status']); ?>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-applications">
                <p>You haven't submitted any applications yet.</p>
                <a href="jobslog.php" class="view-btn" style="margin-top: 15px;">
                    <i class="fas fa-search"></i> Browse Jobs
                </a>
            </div>
        <?php endif; ?>
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