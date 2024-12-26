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

// Form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Reset error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    document.querySelectorAll('.input-group input').forEach(input => {
        input.style.borderColor = '#ddd';
    });

    let hasError = false;

    // Validasi email
    if (!email) {
        e.preventDefault();
        showError('email', 'Email harus diisi');
        hasError = true;
    }

    // Validasi password
    if (!password) {
        e.preventDefault();
        showError('password', 'Password harus diisi');
        hasError = true;
    }

    if (hasError) {
        e.preventDefault();
    }
});

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
    field.style.borderColor = '#dc2626';
}

// Social login handlers
document.querySelector('.google-btn').addEventListener('click', function() {
    console.log('Google login clicked');
    // Implement Google OAuth login
});

document.querySelector('.linkedin-btn').addEventListener('click', function() {
    console.log('LinkedIn login clicked');
    // Implement LinkedIn OAuth login
}); 