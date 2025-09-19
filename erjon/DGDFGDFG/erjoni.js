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

// Funksioni për të treguar përmbajtjen e karrocës në faqe (për shembull, në faqen e karrocës)
function displayCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.querySelector('.cart-items');
    const totalPriceElement = document.querySelector('.total-price');
    
    // Pastroni karrocën e produktit (nëse ka artikuj të mëparshëm)
    cartItemsContainer.innerHTML = '';
    
    let totalPrice = 0;

    // Kontrolloni nëse ka produkte dhe tregoni ato në faqe
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
    } else {
        cart.forEach(item => {
            const productElement = document.createElement('div');
            productElement.classList.add('cart-item');
            productElement.innerHTML = `
                <div class="cart-item-details">
                    <h3>${item.name}</h3>
                    <p>Price: ${item.price}</p>
                </div>
            `;
            
            cartItemsContainer.appendChild(productElement);

            // Shto çmimin në total
            totalPrice += parseFloat(item.price.replace('$', ''));
        });
    }

    totalPriceElement.innerText = totalPrice.toFixed(2);
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