// Funksioni për të shtuar produkt në karrocën e blerjes
const addToCartButtons = document.querySelectorAll('.btn');

addToCartButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        // Merrni informacionin për produktin
        const productCard = event.target.closest('.product-card');
        const productName = productCard.querySelector('h3').textContent;
        const productImage = productCard.querySelector('img').src;
        const productPrice = productCard.querySelector('p').textContent;

        // Krijoni një objekt produkti
        const product = {
            name: productName,
            image: productImage,
            price: productPrice,
        };

        // Merrni karrocën nga local storage ose inicializoni atë
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Shtoni produktin në karrocë
        cart.push(product);

        // Ruani karrocën e përditësuar në local storage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Informoni përdoruesin se produkti është shtuar në karrocë
        alert(`${productName} është shtuar në karrocën tuaj.`);
    });
});

// Lëvizje e qetë kur klikoni në lidhjet e navigimit
const navLinks = document.querySelectorAll('nav a');

navLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        
        const targetId = link.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);

        window.scrollTo({
            top: targetElement.offsetTop,
            behavior: 'smooth',
        });
    });
});