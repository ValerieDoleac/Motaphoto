// Script pour le menu hamburgeur

document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');

    hamburger.addEventListener('click', function () {
        this.classList.toggle('open'); // Ajoute la classe "open" pour transformer en croix
        menu.classList.toggle('active'); // Affiche/masque le menu mobile
    });
});


// modale

document.addEventListener('DOMContentLoaded', function () {
    const openModalButton = document.querySelector('.open-modal');
    const closeModalButton = document.querySelector('.close-modal');
    const modalContainer = document.querySelector('.modal-container');

    if (openModalButton && closeModalButton && modalContainer) {
        openModalButton.addEventListener('click', function () {
            modalContainer.style.display = 'flex'; // Affiche la modale
        });

        closeModalButton.addEventListener('click', function () {
            modalContainer.style.display = 'none'; // Cache la modale
        });

        // Fermer la modale en cliquant en dehors
        modalContainer.addEventListener('click', function (e) {
            if (e.target === modalContainer) {
                modalContainer.style.display = 'none';
            }
        });
    }
});



