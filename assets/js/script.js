document.addEventListener('DOMContentLoaded', function () {
    // Sélecteurs généraux
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalLinks = document.querySelectorAll('.open-modal'); // Liens avec "open-modal"
    
    // Sélecteurs pour le carrousel
    const carouselImages = document.querySelector('.carousel-images');
    const images = carouselImages ? carouselImages.querySelectorAll('img') : [];
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    let currentIndex = 0; // Position actuelle dans le carrousel
    const imageWidth = 81 + 10; // Largeur d'une image + l'espace (gap)

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
                if (menu && menu.classList.contains('active')) {
                    hamburger.classList.remove('open');
                    menu.classList.remove('active');
                }

                // Affiche la modale
                modal.classList.add('active');
                overlay.classList.add('active');
                document.body.classList.add('modal-active'); // Empêche le scroll derrière la modale
            });
        });

        // Fermer la modale en cliquant sur l'overlay
        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('modal-active'); // Réactive le scroll
        });
    }

    // Gestion du carrousel
        if (carouselImages && images.length > 0 && prevButton && nextButton) {
        // Fonction pour mettre à jour le défilement du carrousel
        function updateCarousel() {
            const offset = -currentIndex * imageWidth; // Calcule la translation
            carouselImages.style.transform = `translateX(${offset}px)`; // Déplace les images
            carouselImages.style.transition = 'transform 0.3s ease-in-out'; // Animation fluide
        }

        // Gestion du bouton "Précédent"
        prevButton.addEventListener('click', function () {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1; // Revient à la dernière image si au début
            updateCarousel();
        });

        // Gestion du bouton "Suivant"
        nextButton.addEventListener('click', function () {
            currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0; // Revient à la première image si à la fin
            updateCarousel();
        });
    }
});










