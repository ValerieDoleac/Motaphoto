function test() {
    console.log(filterPhotos("category", "mariage"));
}

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
        const reference = referenceChamp ? referenceChamp.textContent : ''; // récupere la référence dans le champ

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


        //carousel

    

});
document.addEventListener("DOMContentLoaded", () => {
    const thumbnailsContainer = document.querySelector(".carousel-images");
    const prevButton = document.querySelector(".prev-button");
    const nextButton = document.querySelector(".next-button");
    const categorie = document.getElementById('categorie');

    let currentIndex = 0;
    let photosArray = [];

    // 📌 Fonction pour charger les photos via AJAX et les insérer dans le carousel
    function loadPhotosForCarousel() {
        filterPhotos("category", categorie.textContent)
            .then(response => {
                // Convertir la réponse en un élément HTML temporaire
                let tempDiv = document.createElement("div");
                tempDiv.innerHTML = response;

                // Récupérer les `.photo-item` de la réponse AJAX
                photosArray = Array.from(tempDiv.querySelectorAll(".photo-item"));
                
                if (photosArray.length > 0) {
                    thumbnailsContainer.innerHTML = ""; // Efface le contenu actuel
                    photosArray.forEach(photo => {
                        thumbnailsContainer.appendChild(photo); // Ajoute chaque photo
                    });

                    showThumbnail(0); // Affiche la première image
                    attachCarouselEvents(); // Active les boutons
                }
            })
            .catch(error => console.error("Erreur chargement carrousel :", error));
    }

    // 📌 Fonction pour afficher la miniature active
    function showThumbnail(index) {
        photosArray.forEach(thumb => {
            thumb.classList.remove("photo-item");
            thumb.classList.add("carousel-thumbnail");

        });
        photosArray.forEach(thumb => {
            thumb.classList.remove("active");
        });

        if (photosArray[index]) {
            photosArray[index].classList.add("active");
        }
    }

    // 📌 Fonction pour attacher les événements du carousel
    function attachCarouselEvents() {
        if (photosArray.length === 0) return; // Vérification pour éviter les erreurs

        prevButton.addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + photosArray.length) % photosArray.length;
            showThumbnail(currentIndex);
        });

        nextButton.addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % photosArray.length;
            showThumbnail(currentIndex);
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "ArrowLeft") {
                currentIndex = (currentIndex - 1 + photosArray.length) % photosArray.length;
            } else if (e.key === "ArrowRight") {
                currentIndex = (currentIndex + 1) % photosArray.length;
            }
            showThumbnail(currentIndex);
        });
    }

    // 📌 Charger les photos dès le chargement du DOM
    loadPhotosForCarousel();
});



// Fonction pour charger plus de photos avec AJAX (charger plus)
function loadImage(num){
    let photoGrid = document.querySelector(".photo-grid");
    let perPage = num;
    // nouvelle requete ajax
    let xhr = new XMLHttpRequest();
    xhr.open("POST", motaphoto_ajax.ajax_url, true);
    // Envoi de la requete au serveur
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {

        if (xhr.status === 200) {
            let response = xhr.responseText;
            if (response.trim() !== "") {
                photoGrid.innerHTML = response; // Ajoute les nouvelles photos
                // réapplique le lightbox
                window.attachLightboxEvents();
            }
        }
    };
    xhr.send("action=load_more_photos&page=" + "&per_page=" + perPage);
}

// Ouverture des listes

document.addEventListener("DOMContentLoaded", () => {
    const photoGrid = document.querySelector(".photo-grid");

    // Fonction unique pour gérer les filtres avec AJAX
    function updatePhotos(filterType, filterValue) {
    const formData = new URLSearchParams();
    formData.append('action', 'filter_photos');
    formData.append('filter_type', filterType);
    formData.append('value', filterValue);
    console.log(`Filtre envoyé : type=${filterType}, value=${filterValue}`);


    fetch(motaphoto_ajax.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData.toString()
    })
    .then(response => response.text())
    .then(data => {
        const photoGrid = document.querySelector('.photo-grid');
        photoGrid.innerHTML = data;
        attachLightboxEvents(); // Recharge les événements de lightbox
    })
    .catch(error => console.error("Erreur AJAX :", error));
}


    // Fonction pour attacher les événements aux filtres
    function attachFilterEvents() {
        document.querySelectorAll('.filter-item').forEach(item => {
            item.addEventListener('click', function () {
                const filterType = this.dataset.filterType;   // "category" ou "format"
                const filterValue = this.dataset.value;       // slug ou ID
                updatePhotos(filterType, filterValue);
            });
        });
    }

    // Ouvrir et Fermer les listes de filtres
    document.querySelectorAll('.filter-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);

            // Ferme toutes les autres
            document.querySelectorAll('.filter-list').forEach(list => {
                list.style.display = 'none';
            });

            // Affiche la liste actuelle
            const filterList = this.nextElementSibling;
            filterList.style.display = isExpanded ? 'none' : 'block';
        });
    });

    // Fermer les listes au clic en dehors
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.filters-box')) {
            document.querySelectorAll('.filter-list').forEach(list => {
                list.style.display = 'none';
            });
        }
    });

    // Lance les événements filtres au chargement
    attachFilterEvents();
});


// fonction pour charger les photos en fonction des filtres
document.addEventListener("DOMContentLoaded", () => {
    const photoGrid = document.querySelector(".photo-grid");

    // Fonction principale pour gérer les filtres avec AJAX
    function attachFilterEvents() {
        
        document.querySelectorAll('.filter-item').forEach(item => {
            item.addEventListener('click', function () {
                const filterType = this.dataset.filterType;
                const filterValue = this.dataset.value;
                updatePhotos(filterType, filterValue);
            });
        });
        
        
        document.querySelectorAll('.sort-item').forEach(item => {
            item.addEventListener('click', function () {
                const sortValue = this.dataset.sort;
                updatePhotos('sort', sortValue);
            });
        });
    }

    // Fonction AJAX pour charger les photos selon les filtres
    function updatePhotos(filterType, filterValue) {
        let categorieFilter=document.getElementById("filter-categories");
        let formatFilter=document.getElementById("filter-formats");
        let sortFilter=document.getElementById("filter-sort");

        if (filterType === "category") {
            categorieFilter.textContent = filterValue;
            formatFilter.textContent = "FORMATS";
            sortFilter.textContent = "TRIER PAR";
        } else if (filterType === "format") {
            formatFilter.textContent = filterValue;
            sortFilter.textContent = "TRIER PAR";
            categorieFilter.textContent = "CATEGORIES";
        } else if (filterType === "TRIER PAR") {
            sortFilter.textContent = filterValue;
            formatFilter.textContent = "FORMATS";
            categorieFilter.textContent = "CATEGORIES";
        }
        const photoGrid = document.querySelector('.photo-grid');    
        let data = filterPhotos(filterType, filterValue);
        photoGrid.innerHTML = data; // Met à jour la galerie avec les nouvelles images
        attachLightboxEvents();
    }

    // Applique les filtres dès le chargement
    attachFilterEvents();
});

function filterPhotos (filterType, filterValue) {
    return fetch(motaphoto_ajax.ajax_url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=filter_photos&filter_type=${filterType}&value=${filterValue}`
    })
    .then(response => response.text())   
    .catch(error => console.error("Erreur AJAX :", error));
}




