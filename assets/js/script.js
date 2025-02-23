document.addEventListener('DOMContentLoaded', function () {
    const menuCache = document.querySelector(".menuCache");
    const shopCategorie = document.querySelector(".shopCategorie");
    let transitioning = false;
    let html = document.querySelector("html");
    let switchMode = document.querySelector(".buttonSwitch");

    function apparitionGrosMenu() {
        if (!transitioning) {
            transitioning = true;
            if (menuCache.classList.contains('is-visible')) {
                menuCache.classList.remove('is-visible');
            } else {
                menuCache.classList.add('is-visible');
            }
            setTimeout(() => {
                transitioning = false; // Fin de la transition après 500 ms
            }, 300);
        }

    }

    function chargementJeuCouleur() {
        if (window.matchMedia("color-scheme: light")) {
            html.classList.add("light");
        } else if (window.matchMedia("color-scheme: dark")) {
            html.classList.add("dark");
            switchMode.classList.add("switch");
        }
    }

    function changementMode() {
        switchMode.classList.toggle('switch');
        if (switchMode.classList.contains('switch')) {
            html.classList.remove('light');
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
        }
    }

    window.addEventListener('load', chargementJeuCouleur);
    switchMode.addEventListener('click', changementMode);

    shopCategorie.addEventListener('click', apparitionGrosMenu);

});