// main.js

// Rrëshqitje e butë për lidhjet me anchor
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// Shembull funksionaliteti: Shfaq një alarm kur klikohet butoni "Shop Now"
const shopButtons = document.querySelectorAll('.btn');

shopButtons.forEach(button => {
    button.addEventListener('click', function (e) {
        alert('Po të ridrejtojmë në faqen e produktit!');
    });
});

// Opsionale: Ndryshimi i imazhit të produktit kur kalon miu mbi të
const productImages = document.querySelectorAll('.product-card img');

productImages.forEach(img => {
    img.addEventListener('mouseover', function () {
        this.style.transform = 'scale(1.1)';
        this.style.transition = 'transform 0.3s ease';
    });

    img.addEventListener('mouseout', function () {
        this.style.transform = 'scale(1)';
    });
});