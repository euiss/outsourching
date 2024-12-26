<?php
//session_start();
// Jika sudah login, redirect ke halaman yang sesuai
//if(isset($_SESSION['user_id'])) {
    //header("Location: index.html");
   // exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
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
    </style>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="nav-links">
            <a href="jobs.php">All Jobs</a>
            <a href="login.php" class="sign-in active">Sign in</a>
            <a href="register.php" class="create-account">Create Account</a>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section">
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back!</h1>
                <p>Sign in to continue your job search</p>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
            <?php endif; ?>

            <form id="loginForm" class="login-form" action="process_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="text" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                <button type="submit" class="login-btn">Sign In</button>

            </form>
        </div>
    </section>

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

    <script src="js/login.js"></script>
</body>
</html> 