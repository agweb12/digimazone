document.addEventListener('DOMContentLoaded', function () {
    const menuCache = document.querySelector(".menuCache");
    const shopCategorie = document.querySelector(".shopCategorie");

    function apparitionGrosMenu() {
        if (menuCache.classList.contains('is-visible')) {
            menuCache.classList.remove('is-visible');
        } else {
            menuCache.classList.add('is-visible');
        }
    }


    shopCategorie.addEventListener('click', apparitionGrosMenu);

});