jQuery.noConflict();
console.log("JQuery chargé :", typeof jQuery);
console.log("📜 [TEST] Le fichier script.js est bien chargé et s'exécute !");





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
        }, { passive: true });
    }
});

// Gestion de la modale
document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ DOM chargé !");
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.modal-overlay');
    const referenceField = document.querySelector('#reference-input');
    const referenceChamp = document.querySelector('.reference');
    const boutonsModal = document.querySelectorAll('.open-modal');
    const reference = referenceChamp ? referenceChamp.textContent : '';
    if (!modal || !overlay) {
        console.warn("⚠️ La modale ou l'overlay sont introuvables !");
        return;
    }

    for (let i = 0; i < boutonsModal.length; i++) {
        // 🔹 Écoute tous les clics sur le document
        boutonsModal[i].addEventListener('click', function (e) {

            e.preventDefault(); // 🔹 Bloque la redirection

            modal.classList.add('active');
            overlay.classList.add('active');
            document.body.classList.add('modal-active');

            if (referenceField && reference) {
                referenceField.value = reference;
            }
        });
    }


    // 🔹 Ferme la modale en cliquant sur l'overlay
    overlay.addEventListener('click', () => {
        console.log("📢 Clic sur l'overlay, fermeture de la modale !");
        modal.classList.remove('active');
        overlay.classList.remove('active');
        document.body.classList.remove('modal-active');
    }, { passive: true });
});


// Fonction pour charger plus de photos avec AJAX (charger plus)
function loadImage(num) {
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

jQuery(document).ready(function ($) {

    // Fonction pour ouvrir et fermer les menus déroulants des filtres
    $(".filter-toggle").on("click", function (e) {
        e.stopPropagation(); // Empêche la propagation pour éviter la fermeture immédiate

        let isExpanded = $(this).attr("aria-expanded") === "true";

        // Ferme toutes les autres listes
        $(".filter-list").hide();
        $(".filter-toggle").attr("aria-expanded", "false");

        // Ouvre ou ferme la liste sélectionnée
        if (!isExpanded) {
            $(this).attr("aria-expanded", "true");
            $(this).next(".filter-list").show();
        }
    });

    // Fermer les listes lorsqu'on clique en dehors
    $(document).on("click", function () {
        $(".filter-list").hide();
        $(".filter-toggle").attr("aria-expanded", "false");
    });

    // Fonction AJAX pour mettre à jour les photos en fonction des filtres
    $(".filter-item").on("click", function () {
        let selectedCategory = $("#filter-categories").data("value") || "";
        let selectedFormat = $("#filter-formats").data("value") || "";
        let selectedSort = $("#filter-sort").data("value") || "DESC";

        // Mise à jour du texte des boutons
        if ($(this).data("categorie")) {
            selectedCategory = $(this).data("categorie");
            $("#filter-categories").text($(this).text()).data("value", selectedCategory);
        } else if ($(this).data("format")) {
            selectedFormat = $(this).data("format");
            $("#filter-formats").text($(this).text()).data("value", selectedFormat);
        } else if ($(this).data("sort")) {
            selectedSort = $(this).data("sort");
            $("#filter-sort").text($(this).text()).data("value", selectedSort);
        }

        // Afficher dans la console pour debug
        console.log("Filtres envoyés ->", {
            categorie: selectedCategory,
            format: selectedFormat,
            sort: selectedSort,
        });

        // Ferme la liste après sélection
        $(".filter-list").hide();
        $(".filter-toggle").attr("aria-expanded", "false");

        // Envoi AJAX
        $.ajax({
            type: "POST",
            url: motaphoto_ajax.ajax_url,
            data: {
                action: "filter_photos",
                categorie: selectedCategory,
                format: selectedFormat,
                sort: selectedSort,
            },
            beforeSend: function () {
                $(".photo-grid").html("<p>Chargement des photos...</p>");
            },
            success: function (response) {
                $(".photo-grid").html(response);
                attachLightboxEvents();
            },
            error: function () {
                console.error("Erreur lors du chargement des photos.");
            },
        });
    });

});

// permet d'appuyer sur une photo en mobile pour afficher  le détail des photos
document.addEventListener("DOMContentLoaded", function () {
    const lightboxLinks = document.querySelectorAll(".open-lightbox");

    function isMobile() {
        return window.innerWidth <= 375; // Définit un mode mobile
    }

    lightboxLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            if (isMobile()) {
                e.preventDefault(); // Empêche la lightbox de s'ouvrir

                // Trouver l'élément parent .photo-item
                const photoItem = this.closest(".photo-item");
                if (!photoItem) {
                    return;
                }

                // Trouver le lien vers la page de détails
                const photoLink = photoItem.querySelector(".eye-icon");
                if (!photoLink || !photoLink.href || photoLink.href === "#") {
                    return;
                }

                window.location.href = photoLink.href; // Redirection vers la page de détails
            }
        });
    });
});





jQuery(document).ready(function ($) {

    function filterPhotos(filterType, filterValue) {

        return $.ajax({
            type: "POST",
            url: motaphoto_ajax.ajax_url,
            data: {
                action: "filter_photos",
                categorie: filterType === "category" ? filterValue : "",
                format: filterType === "format" ? filterValue : "",
                sort: filterType === "sort" ? filterValue : "DESC",
            }
        }).fail(function () {
            console.error("Erreur lors du chargement des photos.");
        });
    }

    function loadPhotosForCarousel() {
        const thumbnailsContainer = document.querySelector(".carousel-images");
        const prevButton = document.querySelector(".prev-button");
        const nextButton = document.querySelector(".next-button");
        const categorie = document.getElementById('categorie');
        let currentIndex = 0;
        let photosArray = [];
        if (thumbnailsContainer != null) {
            filterPhotos("category", categorie.textContent)
                .then(response => {
                    let tempDiv = document.createElement("div");
                    tempDiv.innerHTML = response;

                    // Récupérer les `.photo-item` de la réponse AJAX
                    photosArray = Array.from(tempDiv.querySelectorAll(".photo-item"));
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

                    if (photosArray.length > 0) {
                        thumbnailsContainer.innerHTML = ""; // Efface le contenu actuel
                        photosArray.forEach(photo => {
                            thumbnailsContainer.appendChild(photo); // Ajoute chaque photo
                        });

                        showThumbnail(0); // Affiche la première image
                        attachCarouselEvents(); // Active les boutons
                    } else {
                        console.warn("⚠️ Aucune photo trouvée pour le carrousel !");
                    }
                })
                .catch(error => console.error("Erreur chargement carrousel :", error));
        }
    }


    loadPhotosForCarousel();

});








