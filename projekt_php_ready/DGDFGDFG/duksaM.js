// main.js

// Funksioni për të shtuar një produkt në karrocë
function addToCart(event) {
    const productName = event.target.parentElement.querySelector('h2').textContent;
    alert(`${productName} është shtuar në karrocën tuaj!`);
}

// Cakto butonët "Add to Cart" me funksionin për t'i shtuar në karrocë
const addToCartButtons = document.querySelectorAll('.product button');
addToCartButtons.forEach(button => {
    button.addEventListener('click', addToCart);
});

// Efekti i kalimit të miut mbi produkt
const products = document.querySelectorAll('.product');

products.forEach(product => {
    product.addEventListener('mouseover', function() {
        product.style.transform = 'scale(1.05)';
        product.style.transition = 'transform 0.3s ease';
    });

    product.addEventListener('mouseout', function() {
        product.style.transform = 'scale(1)';
    });
});

// Efekti i ngjyrosjes për butonat kur kalon miu
const buttons = document.querySelectorAll('.product button');

buttons.forEach(button => {
    button.addEventListener('mouseover', function() {
        button.style.backgroundColor = '#ffcc00'; // Ngjyra kur kalon miu
    });

    button.addEventListener('mouseout', function() {
        button.style.backgroundColor = ''; // Rikthehet në ngjyrën fillestare
    });
});