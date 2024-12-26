// Filter functionality
document.querySelectorAll('.filters select').forEach(select => {
    select.addEventListener('change', function() {
        // Implement filter logic here
        console.log('Filter changed:', this.name, this.value);
    });
});

// Search functionality
document.querySelector('.search-btn').addEventListener('click', function() {
    const searchQuery = document.querySelector('.search-box input:first-child').value;
    const location = document.querySelector('.search-box input:last-child').value;
    // Implement search logic here
    console.log('Search:', searchQuery, location);
});

// Pagination functionality
document.querySelectorAll('.page-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // Add active class to clicked button
        this.classList.add('active');
        // Implement pagination logic here
        console.log('Page changed:', this.textContent);
    });
}); 