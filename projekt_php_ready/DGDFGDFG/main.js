// main.js

// Funksioni për të shtuar produkte në karrocë
function addToCart(event) {
    // Merr informacionet për produktin (emri dhe çmimi)
    const productElement = event.target.closest('.product');
    const productName = productElement.querySelector('h2').innerText;
    const productPrice = productElement.querySelector('p').innerText;

    // Regjistro produktin e shtuar në karrocë (mund të përmirësohet për të ruajtur artikujt në një vend tjetër)
    console.log(`Shtuar në Karrocë: ${productName} - ${productPrice}`);

    // Mundësisht, trego një mesazh për përdoruesin
    alert(`${productName} është shtuar në karrocën tuaj.`);
}

// Shto dëgjues për të gjitha butonat "Add to Cart"
document.querySelectorAll('.product button').forEach(button => {
    button.addEventListener('click', addToCart);
});