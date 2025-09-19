// main.js

// Funksioni për të shtuar një produkt në karrocë
function addToCart(productId, productName, productPrice) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Krijoni një objekt për produktin dhe shtoni atë në karrocë
    const product = {
        id: productId,
        name: productName,
        price: productPrice
    };
    
    // Kontrolloni nëse produkti është tashmë në karrocë
    const existingProductIndex = cart.findIndex(item => item.id === productId);
    
    if (existingProductIndex > -1) {
        // Nëse produkti ekziston, mund të rrisni sasinë ose mund të bëni diçka tjetër
        alert('Product already in cart!');
    } else {
        // Shto produktin në karrocë
        cart.push(product);
        // Ruaj karrocën në localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Përditëso numrin e artikujve në karrocë në navbar
    updateCartCount();
}

// Funksioni për të përditësuar numrin e artikujve në karrocë
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = cart.length;
    const cartElement = document.querySelector('.cart-count');
    
    if (cartElement) {
        cartElement.innerText = cartCount;
    }
}

// Thirr funksionin për të përditësuar numrin e artikujve në karrocë kur faqja të ngarkohet
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});

// Për të lidhur butonat "Add to Cart" me funksionin addToCart
const addToCartButtons = document.querySelectorAll('.product button');
addToCartButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const productCard = button.closest('.product');
        const productId = productCard.querySelector('img').getAttribute('alt'); // Përdorim 'alt' si ID produkti
        const productName = productCard.querySelector('h2').innerText;
        const productPrice = productCard.querySelector('p').innerText;

        addToCart(productId, productName, productPrice);
    });
});