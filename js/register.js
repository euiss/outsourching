// Toggle password visibility
document.querySelector('.toggle-password').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    }
});

// Handle form submission
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const fullname = document.getElementById('fullname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const terms = document.querySelector('input[name="terms"]').checked;

    // Validasi nama
    if (fullname.trim().length < 3) {
        e.preventDefault();
        alert('Nama lengkap harus minimal 3 karakter!');
        return;
    }

    // Validasi email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid!');
        return;
    }
    
    // Validasi password
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Password dan Confirm Password tidak cocok!');
        return;
    }
    
    // Validasi panjang password
    if (password.length < 8) {
        e.preventDefault();
        alert('Password harus minimal 8 karakter!');
        return;
    }
    
    // Validasi password mengandung huruf dan angka
    if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password)) {
        e.preventDefault();
        alert('Password harus mengandung huruf dan angka!');
        return;
    }

    // Validasi terms
    if (!terms) {
        e.preventDefault();
        alert('Anda harus menyetujui Terms of Service dan Privacy Policy');
        return;
    }
});

// Social register handlers
document.querySelector('.google-btn').addEventListener('click', function() {
    console.log('Google registration clicked');
    // Implement Google OAuth registration
});

document.querySelector('.linkedin-btn').addEventListener('click', function() {
    console.log('LinkedIn registration clicked');
    // Implement LinkedIn OAuth registration
}); 