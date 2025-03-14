document.addEventListener("DOMContentLoaded", function () {
    console.log("script chargé !");

    const lightboxOverlay = document.getElementById("lightbox-overlay");
    const lightboxImage = document.getElementById("lightbox-image");
    const lightboxTitle = document.querySelector(".lightbox-title");
    const lightboxCategory = document.querySelector(".lightbox-category");
    const lightboxClose = document.querySelector(".lightbox-close");
    const prevButton = document.querySelector(".lightbox-prev");
    const nextButton = document.querySelector(".lightbox-next");
    let images = [];
    let currentIndex = 0;

    // Fonction pour ouvrir la lightbox
    function openLightbox(index) {
        console.log("Ouverture de la lightbox avec l'index:", index);
        const image = images[index];
        if (!image) return;

        lightboxImage.src = image.dataset.src;
        lightboxTitle.textContent = image.dataset.title || "Titre";
        lightboxCategory.textContent = image.dataset.category || "Catégorie";
        lightboxOverlay.classList.add("active");
        currentIndex = index;

        // Charger l'image et détecter son orientation
    lightboxImage.onload = function () {
        // Supprimer les classes existantes
        lightboxImage.classList.remove("portrait", "landscape");

        // Vérifier l'orientation et ajouter la classe correspondante
        if (lightboxImage.naturalWidth > lightboxImage.naturalHeight) {
            lightboxImage.classList.add("landscape"); // Image paysage
        } else {
            lightboxImage.classList.add("portrait"); // Image portrait
        }

        console.log("📸 Orientation détectée :", lightboxImage.classList);
    }};

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        lightboxOverlay.classList.remove("active");
    }

    // Image suivante
    function showNextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    openLightbox(currentIndex);
    }

    // Image précédente
    function showPrevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    openLightbox(currentIndex);
    }

    // Fonction pour attacher les événements de la lightbox aux images
    function attachLightboxEvents() {
    images = document.querySelectorAll(".photo-item");

    images.forEach((image, index) => {
        image.removeEventListener("click", handleImageClick);
        image.addEventListener("click", (event) => {
            // Vérifier si le clic vient de l'icône de l'œil (Infos)
            if (event.target.closest(".eye-icon")) {
                return; 
            }

            // Vérifier si le clic vient de l'icône plein écran
            if (event.target.closest(".fullscreen-icon")) {
                event.preventDefault(); 
                openLightbox(index);
                return; 
            }

            event.preventDefault()
            openLightbox(index);
        });
    });
}



    // Fonction de gestion du clic sur les images
    function handleImageClick(event, index) {
        event.preventDefault();
        openLightbox(index);
    }

    // Événements globaux de la lightbox
    lightboxClose.addEventListener("click", closeLightbox);
    prevButton.addEventListener("click", showPrevImage);
    nextButton.addEventListener("click", showNextImage);

    // Fermeture en cliquant sur l'overlay
    lightboxOverlay.addEventListener("click", function (event) {
        if (event.target === lightboxOverlay) {
            closeLightbox();
        }
    });

    // Navigation clavier
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeLightbox();
        } else if (event.key === "ArrowRight") {
            showNextImage();
        } else if (event.key === "ArrowLeft") {
            showPrevImage();
        }
    });

    // Initialiser les événements au chargement initial
    attachLightboxEvents();

    // Exposer la fonction pour les chargements AJAX
    window.attachLightboxEvents = attachLightboxEvents;
});






