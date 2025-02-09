document.addEventListener("DOMContentLoaded", () => {

    // Gestion du menu mobile

    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');

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

    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const openModalLinks = document.querySelectorAll('.open-modal');
    const referenceField = document.querySelector('#reference-input');
    const referenceChamp = document.querySelector('.reference');
    const reference = referenceChamp ? referenceChamp.textContent : '';

    if (modal && overlay && openModalLinks.length > 0) {
        openModalLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.add('active');
                overlay.classList.add('active');
                document.body.classList.add('modal-active');

                if (referenceField && reference) {
                    referenceField.value = reference;
                }
            });
        });

        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('modal-active');
        });
    }

    // Gestion du carrousel

    const carouselImages = document.querySelector('.carousel-images');
    const thumbnails = carouselImages ? carouselImages.querySelectorAll('.carousel-thumbnail') : [];
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const mainPhoto = document.getElementById('main-photo');
    let currentIndex = 0;

    if (carouselImages && thumbnails.length > 0 && prevButton && nextButton && mainPhoto) {
        function updateActiveThumbnail() {
            thumbnails.forEach((thumb, index) => {
                thumb.classList.toggle('active', index === currentIndex);
            });

            const thumbWidth = thumbnails[0].offsetWidth;
            const thumbMargin = parseInt(getComputedStyle(thumbnails[0]).marginRight, 10) || 0;
            const offset = thumbWidth + thumbMargin;
            carouselImages.scrollLeft = currentIndex * offset;

            const largeUrl = thumbnails[currentIndex].dataset.large || '';
            if (largeUrl) {
                mainPhoto.src = largeUrl;
            }
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? thumbnails.length - 1 : currentIndex - 1;
            updateActiveThumbnail();
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex === thumbnails.length - 1) ? 0 : currentIndex + 1;
            updateActiveThumbnail();
        });

        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                currentIndex = index;
                updateActiveThumbnail();
            });
        });

        updateActiveThumbnail();
    }

document.addEventListener("DOMContentLoaded", () => {
    const photoGrid = document.querySelector(".photo-grid");
    if (photoGrid) {
        photoGrid.style.display = "grid";
        photoGrid.style.gridTemplateColumns = "repeat(2, 1fr)";
        photoGrid.style.gap = "20px";
    }
});

    // Bouton charger plus

    const loadMoreButton = document.getElementById("load-more");

    if (loadMoreButton) {
        loadMoreButton.addEventListener("click", function () {
            const currentPage = parseInt(this.getAttribute("data-page"));
            const nextPage = currentPage + 1;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", motaphoto_ajax.ajax_url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            console.log(motaphoto_ajax.ajax_url);


            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText) {
                    const newPhotos = document.createElement("div");
                    newPhotos.innerHTML = xhr.responseText;
                    document.querySelector(".photo-grid").appendChild(newPhotos);
                    loadMoreButton.setAttribute("data-page", nextPage);
                }
            };

            xhr.onerror = function () {
                console.error("Une erreur est survenue pendant la requête AJAX.");
            };

            xhr.send(`action=load_more_photos&page=${nextPage}`);
        });
    }
});




