// Search functionality
document.querySelector('.search-btn').addEventListener('click', function() {
    const searchQuery = document.querySelector('.search-box input:first-child').value;
    const location = document.querySelector('.search-box input:last-child').value;
    // Implement search logic here
});

// Smooth scroll for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Carousel functionality
const carousel = document.querySelector('.carousel');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const jobCards = document.querySelectorAll('.job-card');

let cardIndex = 0;
const cardWidth = jobCards[0].offsetWidth + 32; // Including gap

nextBtn.addEventListener('click', () => {
    if (cardIndex < jobCards.length - 1) {
        cardIndex++;
        carousel.scrollLeft += cardWidth;
    }
});

prevBtn.addEventListener('click', () => {
    if (cardIndex > 0) {
        cardIndex--;
        carousel.scrollLeft -= cardWidth;
    }
});

// Auto scroll carousel
let autoScroll = setInterval(() => {
    if (cardIndex < jobCards.length - 1) {
        cardIndex++;
        carousel.scrollLeft += cardWidth;
    } else {
        cardIndex = 0;
        carousel.scrollLeft = 0;
    }
}, 5000);

// Pause auto scroll on hover
carousel.addEventListener('mouseenter', () => {
    clearInterval(autoScroll);
});

carousel.addEventListener('mouseleave', () => {
    autoScroll = setInterval(() => {
        if (cardIndex < jobCards.length - 1) {
            cardIndex++;
            carousel.scrollLeft += cardWidth;
        } else {
            cardIndex = 0;
            carousel.scrollLeft = 0;
        }
    }, 5000);
});

document.querySelector('.prev-btn').addEventListener('click', function() {
    document.querySelector('.carousel').scrollBy({
        left: -320,
        behavior: 'smooth'
    });
});

document.querySelector('.next-btn').addEventListener('click', function() {
    document.querySelector('.carousel').scrollBy({
        left: 320,
        behavior: 'smooth'
    });
}); 