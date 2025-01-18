document.addEventListener('DOMContentLoaded', function () {
    // Sélecteurs
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalButton = document.querySelector('.open-modal');

    // Gestion du menu hamburger
    if (hamburger && menu) {
        hamburger.addEventListener('click', function () {
            this.classList.toggle('open'); // Transforme en croix
            menu.classList.toggle('active'); // Affiche/masque le menu
        });

        // Ferme le menu si on clique à l'extérieur
        document.addEventListener('click', function (e) {
            if (menu.classList.contains('active') && !menu.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('open');
                menu.classList.remove('active');
            }
        });
    }

    // Gestion de la modale
    if (openModalButton && modal && overlay) {
        openModalButton.addEventListener('click', function () {
            modal.classList.add('active'); // Affiche la modale
            overlay.classList.add('active'); // Affiche l'overlay
        });

        overlay.addEventListener('click', function () {
            modal.classList.remove('active'); // Cache la modale
            overlay.classList.remove('active'); // Cache l'overlay
        });
    }
});







