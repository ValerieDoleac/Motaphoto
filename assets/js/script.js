document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalLinks = document.querySelectorAll('.open-modal');

    // Gestion du menu mobile
    if (hamburger && menu) {
        hamburger.addEventListener('click', function () {
            this.classList.toggle('open'); // Transforme le hamburger en croix
            menu.classList.toggle('active'); // Affiche/masque le menu
        });

        document.addEventListener('click', function (e) {
            if (menu.classList.contains('active') && !menu.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('open');
                menu.classList.remove('active');
            }
        });
    }

    // Gestion de la modale
    if (modal && overlay && openModalLinks.length > 0) {
        openModalLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Empêche le comportement par défaut du lien
                
                // Ferme le menu mobile si actif
                if (menu.classList.contains('active')) {
                    hamburger.classList.remove('open');
                    menu.classList.remove('active');
                }

                // Affiche la modale
                modal.classList.add('active');
                overlay.classList.add('active');
            });
        });

        // Fermer la modale en cliquant sur l'overlay
        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
});








