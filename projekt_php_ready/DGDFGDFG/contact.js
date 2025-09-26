// main.js

// Prit që dokumenti të ngarkohet plotësisht para se të shtohen dëgjuesit për ngjarje
document.addEventListener('DOMContentLoaded', () => {
    // Zgjidh formularin e kontaktit
    const contactForm = document.querySelector('.contact-form');

    // Shto një dëgjues për ngjarjen e dërgimit të formularit
    contactForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Parandalon që formulari të dërgohet në mënyrë normale

        // Merr vlerat e fushave të formularit
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Verifikim i thjeshtë i formularit
        if (!name || !email || !message) {
            alert('Ju lutem plotësoni të gjitha fushat.');
            return;
        }

        // Nëse formulari është i vlefshëm, shfaq një mesazh suksesi
        alert('Faleminderit për mesazhin tuaj, ' + name + '! Ne do të kontaktojmë me ju shumë shpejt.');

        // Opsionalisht, mund të rivendosim fushat e formularit pas dërgimit të suksesshëm
        contactForm.reset();
    });
});
