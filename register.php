<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Job Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/register.css">
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
            <a href="login.php" class="sign-in">Sign in</a>
            <a href="register.php" class="create-account active">Create Account</a>
        </div>
    </nav>

    <!-- Register Section -->
    <section class="register-section">
        <div class="register-container">
            <div class="register-header">
                <h1>Create Your Account</h1>
                <p>Join us to explore amazing career opportunities</p>
            </div>

            <form id="registerForm" class="register-form" action="process_register.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                        <i class="fas fa-eye-slash toggle-password"></i>
                    </div>
                    <small class="password-hint">Password must be at least 8 characters long and include numbers and letters</small>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    </div>
                </div>

                <div class="form-group terms">
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" required>
                        <span class="checkmark"></span>
                        <span class="terms-text">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                    </label>
                </div>

                <button type="submit" class="register-btn">Create Account</button>

                <div class="divider">
                    <span>or sign up with</span>
                </div>

                <div class="social-register">
                    <button type="button" class="google-btn">
                        <img src="images/google-icon.png" alt="Google">
                        Google
                    </button>
                    <button type="button" class="linkedin-btn">
                        <i class="fab fa-linkedin"></i>
                        LinkedIn
                    </button>
                </div>

                <p class="login-link">
                    Already have an account? <a href="login.html">Sign In</a>
                </p>
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

    <!--<script src="js/register.js"></script>-->
</body>
</html> 