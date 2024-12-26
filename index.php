<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/customer-service.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;  /* Warna background light gray */
            margin: 0;
            padding: 0;
        }

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

        .features {
            background-color: #ffffff;  /* Warna background putih untuk section features */
            padding: 50px 0;
            margin: 30px 0;
        }

        .high-demand-jobs {
            background-color: #ffffff;  /* Warna background putih untuk section lowongan */
            padding: 50px 0;
            margin: 30px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <div class="nav-links">
            <a href="jobs.php" class="active">All Jobs</a>
            <a href="login.php" class="sign-in">Sign in</a>
            <a href="register.php" class="create-account">Create Account</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/bg.jpg'); background-size: cover; background-position: center;">
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
        <a href="jobs.php" class="active"><button class="explore-btn">Explore Now</button></a>
    </section>

    <!-- High-Demand Jobs Section -->
    <section class="high-demand-jobs">
        <h2>Lowongan Terbaru</h2>
        <p>Explore the latest opportunities from top companies</p>
        
        <div class="carousel-container">
            <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
            <div class="carousel">
                <?php
                require_once 'admin/config/database.php';
                
                // Query untuk mengambil 10 lowongan terbaru
                $query = "SELECT l.*, c.client_name, c.logo 
                         FROM lowongan l
                         LEFT JOIN client c ON l.id_client = c.id_client
                         WHERE l.status = 'Active'
                         ORDER BY l.mulai DESC
                         LIMIT 10";
                         
                $result = mysqli_query($conn, $query);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    while($job = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="job-card">
                            <img src="admin/uploads/logos/<?php echo $job['logo'] ?: 'default-logo.png'; ?>" 
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
                            <a href="login.php" class="apply-btn">Apply Now</a>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="no-jobs">
                        <p>Tidak ada lowongan tersedia saat ini.</p>
                    </div>
                    <?php
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