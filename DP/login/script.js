document.addEventListener('DOMContentLoaded', function () {
    const content = document.getElementById('content');
    const loginBtn = document.getElementById('loginBtn');

    loginBtn.addEventListener('click', function () {
        window.location.href = '/auth/google'; // Přesměruje na Google OAuth
    });

    // Zkontroluje, zda je uživatel přihlášen
    fetch('/auth/check', { credentials: 'include' })
        .then(response => response.json())
        .then(user => {
            if (user.isLoggedIn) {
                showDashboard(user.displayName);
            }
        });
});

function showDashboard(displayName) {
    const content = document.getElementById('content');
    content.innerHTML = `<h1>Vítejte, ${displayName}!</h1><button id="logoutBtn">Odhlásit se</button><div id="data"></div>`;

    document.getElementById('logoutBtn').addEventListener('click', function () {
        window.location.href = '/logout';
    });

    fetch('/api/data', { credentials: 'include' })
        .then(response => response.json())
        .then(data => {
            const dataDiv = document.getElementById('data');
            dataDiv.innerHTML = '<h2>Data v databázi:</h2><ul>';
            data.forEach(item => {
                dataDiv.innerHTML += `<li>${item}</li>`;
            });
            dataDiv.innerHTML += '</ul>';
        });
}
