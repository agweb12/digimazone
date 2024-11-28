document.addEventListener('DOMContentLoaded', function () {
    const menuCache = document.querySelector(".menuCache");
    const shopCategorie = document.querySelector(".shopCategorie");
    let transitioning = false;

    function apparitionGrosMenu() {
        if(!transitioning){
            transitioning = true;
            if (menuCache.classList.contains('is-visible')) {
                menuCache.classList.remove('is-visible');
            } else {
                menuCache.classList.add('is-visible');
            };
            setTimeout(() => {
                transitioning = false; // Fin de la transition après 500 ms
            }, 300);
        };
        
    };

    shopCategorie.addEventListener('click', apparitionGrosMenu);


    // const CHAT = "Simba";

    // let chien = CHAT;
    // console.log(typeof chien, chien);
});