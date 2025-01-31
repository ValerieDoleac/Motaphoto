<?php

// Charger les styles et scripts du thème
function motaphoto_enqueue_assets() {
    
    // Charger les polices
    wp_enqueue_style(
        'motaphoto-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        array(),
        null
    );

    // Charger le fichier principal style.css
    wp_enqueue_style(
        'motaphoto-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_stylesheet_directory() . '/style.css') // Ajout du versioning pour éviter le cache
    );

    // Charger le script JavaScript principal
    wp_enqueue_script(
        'motaphoto-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'), // Ajout de la dépendance à jQuery si nécessaire
        filemtime(get_template_directory() . '/assets/js/script.js'), // Ajout du versioning
        true // Chargement dans le footer
    );
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_assets');

// Enregistrer les menus du thème
function motaphoto_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'motaphoto'), // Menu principal
        'footer'  => __('Menu Footer', 'motaphoto'), // Menu footer
    ));
}
add_action('after_setup_theme', 'motaphoto_register_menus');

// Ajouter le support des fonctionnalités du thème
function motaphoto_theme_support() {
    // Support des images mises en avant
    add_theme_support('post-thumbnails');

    // Support du titre dynamique dans l'en-tête
    add_theme_support('title-tag');

    // Ajouter le support des HTML5 pour les formulaires et commentaires
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'motaphoto_theme_support');

// Associer les taxonomies au type de contenu personnalisé "Photo"
function associate_taxonomies_to_photo() {
    if (taxonomy_exists('category')) {
        register_taxonomy_for_object_type('category', 'photo');
    }

    if (taxonomy_exists('format')) {
        register_taxonomy_for_object_type('format', 'photo');
    }
}
add_action('init', 'associate_taxonomies_to_photo');

// Charger les styles spécifiques pour les pages "Photo"
function motaphoto_enqueue_single_photo_styles() {
    if (is_singular('photo')) {
        wp_enqueue_style(
            'single-photo-style',
            get_template_directory_uri() . '/assets/css/single-photo.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/single-photo.css') // Ajout du versioning
        );
    }
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_single_photo_styles');

// Ajouter des tailles d'image personnalisées
add_action('after_setup_theme', function() {
    add_image_size('photo-large', 563, 844, true); // Taille de la grande photo
    add_image_size('photo-thumbnail', 81, 71, true); // Taille des miniatures
    add_image_size('photo-thumbnail', 564, 495, true);
});

// Activer les mises à jour des miniatures (régénérer automatiquement)
function motaphoto_regenerate_thumbnails_on_upload($attachment_id) {
    if (wp_attachment_is_image($attachment_id)) {
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, get_attached_file($attachment_id)));
    }
}
add_action('add_attachment', 'motaphoto_regenerate_thumbnails_on_upload');



function load_more_photos() {
    // Vérifiez si une page est passée en paramètre
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $photos_per_page = 8; // Nombre de photos à charger par page

    // Créez une nouvelle requête WP_Query
    $query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => $photos_per_page,
        'paged' => $page,
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Incluez votre template de photo ici
            include locate_template('template-parts/photo_block.php');
        }
        wp_reset_postdata();
    } else {
        echo '<p>Aucune photo supplémentaire disponible.</p>';
    }

    wp_die(); // Arrête l'exécution de PHP
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Activer jQuery Migrate manuellement
function enable_jquery_migrate() {
    // Supprime jQuery par défaut de WordPress
    wp_deregister_script('jquery');

    // Recharge jQuery avec jQuery Migrate inclus
    wp_enqueue_script(
        'jquery',
        includes_url('/js/jquery/jquery.min.js'),
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'jquery-migrate',
        includes_url('/js/jquery/jquery-migrate.min.js'),
        array('jquery'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enable_jquery_migrate');






















