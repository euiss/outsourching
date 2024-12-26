<?php
session_start();
include 'admin/config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/customer-service.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <div class="user-info">
            <a href="jobslog.php" class="nav-link">All Jobs</a>
            <?php if(isset($_SESSION['user_id'])): ?>
               
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Explore Your Dream Job.<br>Start Here.</h1>
            <div class="search-box">
                <input type="text" placeholder="Search for jobs...">
                <input type="text" placeholder="Location">
                <button class="search-btn">Search</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Find Amazing Career Opportunities Today</h2>
        <p>Apply to jobs with one-click and connect with recruiters searching for your skills.</p>
        
        <div class="feature-cards">
            <div class="feature-card">
                <i class="fas fa-bell"></i>
                <h3>Get informed about job opportunities</h3>
            </div>
            <div class="feature-card">
                <i class="fas fa-check-circle"></i>
                <h3>Easy apply for desired jobs</h3>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h3>Real-time Application Tracking</h3>
            </div>
        </div>
        <a href="jobslog.php" class="active"><button class="explore-btn">Explore Now</button></a>
    </section>

    <!-- High-Demand Jobs Section -->
    <section class="high-demand-jobs">
        <h2>Lowongan Terbaru</h2>
        <div class="carousel-container">
            <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
            <div class="carousel">
                <?php
                // Query untuk mengambil lowongan terbaru
                $query = "SELECT a.*, b.client_name, b.logo
                         FROM lowongan a
                         LEFT JOIN client b ON a.id_client = b.id_client 
                         WHERE a.status = 'Active' 
                         ORDER BY a.mulai DESC";
                
                // Eksekusi query dengan koneksi yang benar
                if($result = mysqli_query($conn, $query)) {  // Tambahkan parameter $conn
                    if(mysqli_num_rows($result) > 0) {
                        while($job = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="job-card">
                                <img src="images/client/<?php echo $job['logo'] ?: 'default-logo.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($job['client_name']); ?>">
                                <h3><?php echo htmlspecialchars($job['jabatan']); ?></h3>
                                <p class="company"><?php echo htmlspecialchars($job['client_name']); ?></p>
                                <p class="location">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <?php echo htmlspecialchars($job['lokasi']); ?>
                                </p>
                                <div class="salary">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>IDR <?php echo htmlspecialchars($job['gaji']); ?></span>
                                </div>
                                <a href="apply.php?id=<?php echo $job['id_lowongan']; ?>" class="apply-btn">Apply Now</a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='no-jobs'>Belum ada lowongan tersedia.</p>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<p class='error'>Terjadi kesalahan: " . mysqli_error($conn) . "</p>";
                }
                ?>
            </div>
            <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

<!-- Chatbot Floating Button -->
<button id="chatbot-toggle" class="chatbot-toggle">
    <i class="fas fa-comments"></i>
</button>

<!-- Chatbot Interface -->
<div id="chatbot-container" class="chatbot-container">
    <div class="chatbot-header">
        <h3>Customer Support</h3>
        <button id="chatbot-close" class="chatbot-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="chatbot-messages" id="chatbot-messages">
        <div class="message bot">
            <img src="images/bot-avatar.png" alt="Bot" class="bot-avatar">
            <div class="message-content">
                Hallo saya Aira, saya adalah personal assistant dari InJobs, bagaimana saya bisa membantu anda?
            </div>
        </div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="user-input" placeholder="Type your message...">
        <button id="send-message">
            <i class="fas fa-paper-plane"></i>
        </button>
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

    <script src="js/script.js"></script>
    <script src="js/customer-service.js"></script>
</body>
</html> 