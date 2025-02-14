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


    /* carousel */

    document.addEventListener("DOMContentLoaded", () => {
    const carouselImages = document.querySelector(".carousel-images");
    const thumbnails = carouselImages ? carouselImages.querySelectorAll(".carousel-thumbnail") : [];
    const prevButton = document.querySelector(".prev-button");
    const nextButton = document.querySelector(".next-button");
    let currentIndex = 0;

    if (carouselImages && thumbnails.length > 0 && prevButton && nextButton) {

        /* * Met à jour les vignettes visibles et applique l'effet actif*/

        function updateCarousel() {
            thumbnails.forEach((thumb, index) => {
                thumb.style.display = "none"; // Cache toutes les vignettes
                if (index >= currentIndex && index < currentIndex + 3) {
                    // Affiche uniquement 3 vignettes à la fois
                    thumb.style.display = "block";
                }
                thumb.classList.toggle("active", index === currentIndex); // Marque la vignette active
            });
        }


        /*Gestion du bouton précédent*/

        prevButton.addEventListener("click", () => {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : thumbnails.length - 1;
            updateCarousel();
        });


        /*Gestion du bouton suivant*/

        nextButton.addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateCarousel();
        });

        // Initialise le carousel
        updateCarousel();
    }
});

});


    // Bouton charger plus
function loadImage(num){
    let photoGrid = document.querySelector(".photo-grid");
    let perPage = num;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", motaphoto_ajax.ajax_url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {

        if (xhr.status === 200) {
            let response = xhr.responseText;
            if (response.trim() !== "") {
                photoGrid.innerHTML = response; // Ajoute les nouvelles photos
            }
        }
    };
    xhr.send("action=load_more_photos&page=" + "&per_page=" + perPage);
}

// Ouverture des listes

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.filter-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);

            // Fermer les autres filtres
            document.querySelectorAll('.filter-list').forEach(list => {
                list.style.display = 'none';
            });

            // Afficher la liste actuelle
            const filterList = this.nextElementSibling;
            filterList.style.display = !isExpanded ? 'block' : 'none';
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.filters-box')) {
            document.querySelectorAll('.filter-list').forEach(list => {
                list.style.display = 'none';
            });
        }
    });


    document.querySelectorAll('.filter-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);

            // Fermer les autres filtres
            document.querySelectorAll('.filter-list').forEach(list => {
                list.hidden = true;
            });

            const list = this.nextElementSibling;
            if (!expanded) {
                list.hidden = false;
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.filters-box')) {
            document.querySelectorAll('.filter-list').forEach(list => {
                list.hidden = true;
            });
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const filterItems = document.querySelectorAll(".filter-list li");

    filterItems.forEach(item => {
        item.addEventListener("click", function () {
            // Supprime la classe 'active' de tous les éléments
            filterItems.forEach(i => i.classList.remove("active"));

            // Ajoute la classe 'active' à l'élément cliqué
            this.classList.add("active");
        });
    });
});


// Fonction pour mettre à jour les photos avec AJAX
function updatePhotos(category) {
    fetch(motaphoto_ajax.ajax_url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=filter_photos&category=${category}`
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector(".photo-grid").innerHTML = data;
    })
    .catch(error => console.error("Erreur AJAX :", error));
}




