document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jobApplicationForm');
    
    // Load profile data
    loadProfileData();
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        const formData = new FormData(form);
        
        // Add profile data to formData
        formData.append('fullName', document.getElementById('profileName').textContent);
        formData.append('email', document.getElementById('profileEmail').textContent);
        formData.append('phone', document.getElementById('profilePhone').textContent);
        formData.append('address', document.getElementById('profileAddress').textContent);
        
        try {
            const response = await fetch('/api/submit-application', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const result = await response.json();
                alert('Lamaran berhasil dikirim! Kami akan menghubungi Anda melalui email.');
                form.reset();
            } else {
                throw new Error('Gagal mengirim lamaran');
            }
        } catch (error) {
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    async function loadProfileData() {
        try {
            const response = await fetch('/api/profile');
            if (response.ok) {
                const profileData = await response.json();
                
                document.getElementById('profileName').textContent = profileData.fullName;
                document.getElementById('profileEmail').textContent = profileData.email;
                document.getElementById('profilePhone').textContent = profileData.phone;
                document.getElementById('profileAddress').textContent = profileData.address;
            } else {
                throw new Error('Gagal memuat data profil');
            }
        } catch (error) {
            alert('Terjadi kesalahan saat memuat profil: ' + error.message);
        }
    }

    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        // Clear existing error messages
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(msg => msg.remove());
        
        requiredFields.forEach(field => {
            field.classList.remove('error');
            
            if (!field.value) {
                isValid = false;
                field.classList.add('error');
                
                const errorMsg = document.createElement('div');
                errorMsg.className = 'error-message';
                errorMsg.textContent = 'Field ini wajib diisi';
                field.parentNode.appendChild(errorMsg);
            }
            
            // File size validation (max 5MB)
            if (field.type === 'file' && field.files.length > 0) {
                const fileSize = field.files[0].size / 1024 / 1024; // convert to MB
                if (fileSize > 5) {
                    isValid = false;
                    field.classList.add('error');
                    
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.textContent = 'Ukuran file maksimal 5MB';
                    field.parentNode.appendChild(errorMsg);
                }
            }
        });

        return isValid;
    }
}); 