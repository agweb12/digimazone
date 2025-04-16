document.addEventListener('DOMContentLoaded', function () {
    // Validation côté client
    const form = document.querySelector('.register-form');
    if (form) {
        form.addEventListener('submit', function (event) {
            const password = document.getElementById('motDePasse').value;
            const confirmPassword = document.getElementById('confirmMotDePasse').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
            }

            if (password.length < 8) {
                event.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères.');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Validation côté client
    const form = document.querySelector('.login-form');
    if (form) {
        form.addEventListener('submit', function (event) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('motDePasse').value;

            if (!email || !password) {
                event.preventDefault();
                alert('Veuillez remplir tous les champs.');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Validation du formulaire
    const editForm = document.querySelector('.edit-form');
    if (editForm) {
        editForm.addEventListener('submit', function (event) {
            const email = document.getElementById('email').value;
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const telephone = document.getElementById('telephone').value;

            if (!email || !nom || !prenom || !telephone) {
                event.preventDefault();
                alert('Les champs Nom, Prénom, Email et Téléphone sont obligatoires.');
            }
        });
    }
});