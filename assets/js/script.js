// Script pour le menu hamburgeur

document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');

    hamburger.addEventListener('click', function () {
        this.classList.toggle('open'); // Ajoute la classe "open" pour transformer en croix
        menu.classList.toggle('active'); // Affiche/masque le menu mobile
    });
});

