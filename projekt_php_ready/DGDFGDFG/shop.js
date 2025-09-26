// main.js

// Funksioni për të shtuar një produkt në karrocë
function shtoNeKarroce(emriProdukti, cmimiProdukti) {
  let karroca = JSON.parse(localStorage.getItem("karroca")) || [];

  // Kontrollo nëse produkti ekziston tashmë në karrocë
  const produktiEKsistuar = karroca.find(item => item.name === emriProdukti);

  if (produktiEKsistuar) {
      produktiEKsistuar.quantity += 1; // Rrite sasinë e produktit
  } else {
      karroca.push({ name: emriProdukti, price: cmimiProdukti, quantity: 1 });
  }

  // Ruaj karrocën e përditësuar në localStorage
  localStorage.setItem("karroca", JSON.stringify(karroca));

  // Njofto përdoruesin
  alert(`${emriProdukti} është shtuar në karrocën tuaj!`);
}

// Funksioni për të trajtuar të gjitha klikimet mbi butonat "Shto në Karrocë"
document.querySelectorAll('.product button').forEach(button => {
  button.addEventListener('click', (event) => {
      const produktiElement = event.target.closest('.product');
      const emriProdukti = produktiElement.querySelector('h2').textContent;
      const cmimiProdukti = parseFloat(produktiElement.querySelector('p').textContent.replace('$', ''));

      shtoNeKarroce(emriProdukti, cmimiProdukti);
  });
});

// Funksioni për të marrë artikujt e karrocës dhe për t'i shfaqur ato
function shfaqKarrocen() {
  const karroca = JSON.parse(localStorage.getItem("karroca")) || [];
  const karrocaContainer = document.getElementById("cart-container");

  if (karroca.length === 0) {
      karrocaContainer.innerHTML = "<p>Karroca juaj është bosh.</p>";
  } else {
      karrocaContainer.innerHTML = "";
      karroca.forEach(item => {
          const itemElement = document.createElement("div");
          itemElement.classList.add("cart-item");
          itemElement.innerHTML = `
              <h3>${item.name}</h3>
              <p>Çmimi: $${item.price}</p>
              <p>Sasia: ${item.quantity}</p>
          `;
          karrocaContainer.appendChild(itemElement);
      });
  }
}

// Mundësisht, shfaq karrocën kur kaloni në faqen e karrocës
if (document.body.contains(document.getElementById("cart-container"))) {
  shfaqKarrocen();
}
