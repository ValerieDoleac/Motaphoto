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

document.addEventListener("DOMContentLoaded", () => {
    const openModalButton = document.querySelector(".open-modal");
    const modal = document.querySelector(".modal");
    const overlay = document.querySelector(".modal-overlay");

    if (openModalButton && modal && overlay) {
        // Ouvrir la modale
        openModalButton.addEventListener("click", () => {
            modal.classList.add("active");
            overlay.classList.add("active");
        });

        // Fermer la modale en cliquant sur l'overlay
        overlay.addEventListener("click", () => {
            modal.classList.remove("active");
            overlay.classList.remove("active");
        });

        // Fermer la modale en cliquant à l'extérieur du formulaire
        document.addEventListener("click", (e) => {
            if (modal.classList.contains("active") && !modal.contains(e.target) && e.target !== openModalButton) {
                modal.classList.remove("active");
                overlay.classList.remove("active");
            }
        });
    }
});





