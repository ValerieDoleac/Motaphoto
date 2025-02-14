document.addEventListener("DOMContentLoaded", function () {
    console.log("script chargé !");
    const lightboxOverlay = document.getElementById("lightbox-overlay");
    const lightboxImage = document.getElementById("lightbox-image");
    const lightboxTitle = document.querySelector(".lightbox-title");
    const lightboxCategory = document.querySelector(".lightbox-category");
    const lightboxClose = document.querySelector(".lightbox-close");
    const prevButton = document.querySelector(".lightbox-prev");
    const nextButton = document.querySelector(".lightbox-next");
    const images = document.querySelectorAll(".photo-item a.fullscreen-icon");
    let currentIndex = 0;

    function openLightbox(index) {
        console.log("Ouverture de la lightbox avec l'index:", index);
        const image = images[index];
        if (!image) return;
        console.log("Image détectée :", image.getAttribute("href"));

        lightboxImage.src = image.getAttribute("href");
        lightboxTitle.textContent = image.dataset.title || "Sans titre";
        lightboxCategory.textContent = image.dataset.category || "Sans catégorie";
        lightboxOverlay.classList.add("active");
        currentIndex = index;
    }

    function closeLightbox() {
        lightboxOverlay.classList.remove("active");
    }

    function showNextImage() {
        if (currentIndex < images.length - 1) {
            openLightbox(currentIndex + 1);
        }
    }

    function showPrevImage() {
        if (currentIndex > 0) {
            openLightbox(currentIndex - 1);
        }
    }

    images.forEach((image, index) => {
        image.addEventListener("click", function (event) {
            event.preventDefault(); // Empêche l'ouverture du lien dans un nouvel onglet
            openLightbox(index);
        });
    });

    lightboxClose.addEventListener("click", closeLightbox);
    prevButton.addEventListener("click", showPrevImage);
    nextButton.addEventListener("click", showNextImage);

    lightboxOverlay.addEventListener("click", function (event) {
        if (event.target === lightboxOverlay) {
            closeLightbox();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeLightbox();
        } else if (event.key === "ArrowRight") {
            showNextImage();
        } else if (event.key === "ArrowLeft") {
            showPrevImage();
        }
    });
});





