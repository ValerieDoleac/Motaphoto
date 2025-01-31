document.addEventListener('DOMContentLoaded', function () {
    // ========================
    // Gestion du menu mobile
    // ========================
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');

    if (hamburger && menu) {
        hamburger.addEventListener('click', function () {
            this.classList.toggle('open'); // Animation pour transformer le hamburger
            menu.classList.toggle('active'); // Affiche/masque le menu mobile
        });

        document.addEventListener('click', function (e) {
            if (menu.classList.contains('active') && !menu.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('open');
                menu.classList.remove('active');
            }
        });
    }

    // ========================
    // Gestion de la modale
    // ========================
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalLinks = document.querySelectorAll('.open-modal');
    const referenceField = document.querySelector('#reference-input'); // Champ de référence dans la modale

    if (modal && overlay && openModalLinks.length > 0) {
        openModalLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                // Ouvre la modale
                modal.classList.add('active');
                overlay.classList.add('active');
                document.body.classList.add('modal-active'); // Désactive le scroll

                // Remplit le champ "Référence" dans la modale
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

    // ========================
    // Gestion du carrousel
    // ========================
    const carouselImages = document.querySelector('.carousel-images');
    const thumbnails = carouselImages ? carouselImages.querySelectorAll('.carousel-thumbnail') : [];
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    let currentIndex = 0; // Position actuelle dans le carrousel

    if (carouselImages && thumbnails.length > 0 && prevButton && nextButton) {
        // Fonction pour mettre à jour l'image active
        function updateActiveThumbnail() {
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.classList.toggle('active', index === currentIndex); // Ajoute une classe "active" à l'image courante
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

    // ========================
    // Gestion des filtres déroulants
    // ========================
    const filterToggles = document.querySelectorAll('.filter-toggle');

    filterToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const list = this.nextElementSibling; // Sélectionne la liste associée
            const expanded = this.getAttribute('aria-expanded') === 'true' || false;

            // Affiche ou masque la liste
            this.setAttribute('aria-expanded', !expanded);
            list.hidden = expanded; // Cache ou affiche la liste

            // Gestion de l'icône de la flèche
            const arrow = this.querySelector('.arrow');
            if (arrow) {
                arrow.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        });
    });

    // ========================
    // Gestion des boutons "Charger plus" et "Charger moins"
    // ========================
    const photoGrid = document.querySelector('.photo-grid');
    const loadMoreButton = document.querySelector('#load-more');
    const loadLessButton = document.querySelector('#less-button');
    let currentPhotoIndex = 0; // Index actuel des photos affichées
    const photosPerPage = 8; // Nombre de photos affichées par clic

    if (photoGrid && loadMoreButton && loadLessButton) {
        const photos = Array.from(photoGrid.children); // Récupère toutes les photos

        // Affiche un certain nombre de photos
        function updatePhotoDisplay() {
            photos.forEach((photo, index) => {
                photo.style.display = index < currentPhotoIndex ? 'block' : 'none';
            });

            // Affiche ou masque les boutons
            loadMoreButton.style.display = currentPhotoIndex < photos.length ? 'block' : 'none';
            loadLessButton.style.display = currentPhotoIndex > photosPerPage ? 'block' : 'none';
        }

        // Afficher plus de photos
        loadMoreButton.addEventListener('click', () => {
            currentPhotoIndex += photosPerPage;
            updatePhotoDisplay();
        });

        // Réduire les photos affichées
        loadLessButton.addEventListener('click', () => {
            currentPhotoIndex = Math.max(currentPhotoIndex - photosPerPage, photosPerPage);
            updatePhotoDisplay();
        });

        // Initialisation
        currentPhotoIndex = photosPerPage;
        updatePhotoDisplay();
    }
});




