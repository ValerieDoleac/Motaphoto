document.addEventListener('DOMContentLoaded', function () {
    // Sélecteurs généraux
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalLinks = document.querySelectorAll('.open-modal'); // Liens avec "open-modal"
    const referenceField = document.querySelector('#reference-input'); // Champ référence dans la modale

    // Sélecteurs pour le carrousel
    const carouselImages = document.querySelector('.carousel-images');
    const thumbnails = carouselImages ? carouselImages.querySelectorAll('.carousel-thumbnail') : [];
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    let currentIndex = 0; // Position actuelle dans le carrousel

    // Gestion du menu mobile
    if (hamburger && menu) {
        hamburger.addEventListener('click', function () {
            this.classList.toggle('open');
            menu.classList.toggle('active');
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
                e.preventDefault();

                // Affiche la modale
                modal.classList.add('active');
                overlay.classList.add('active');
                document.body.classList.add('modal-active'); // Empêche le scroll

                // Remplit automatiquement le champ "Référence"
                const reference = link.getAttribute('data-reference');
                if (referenceField && reference) {
                    referenceField.value = reference;
                }
            });
        });

        // Ferme la modale en cliquant sur l'overlay
        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('modal-active');
        });
    }

    // Gestion du carrousel
    if (thumbnails.length > 0 && prevButton && nextButton) {
        // Fonction pour mettre à jour l'image active
        function updateActiveThumbnail() {
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.classList.toggle('active', index === currentIndex);
                carouselImages.scrollLeft = currentIndex * (thumbnails[0].offsetWidth + 10); // Scroll vers l'image courante
            });
        }

        // Gestion des flèches
        prevButton.addEventListener('click', function () {
            currentIndex = (currentIndex === 0) ? thumbnails.length - 1 : currentIndex - 1;
            updateActiveThumbnail();
        });

        nextButton.addEventListener('click', function () {
            currentIndex = (currentIndex === thumbnails.length - 1) ? 0 : currentIndex + 1;
            updateActiveThumbnail();
        });

        // Initialisation
        updateActiveThumbnail();
    }
});


