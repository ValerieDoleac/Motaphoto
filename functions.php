<?php
// Charger les styles et scripts du thème
function motaphoto_enqueue_assets() {
    // Charger les polices
    wp_enqueue_style('motaphoto-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), null);

    // Charger le fichier principal style.css
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));

    // Charger le script JavaScript
    wp_enqueue_script('motaphoto-script', get_template_directory_uri() . '/assets/js/script.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_assets');

// Permet à WordPress de gérer les menus
function motaphoto_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'motaphoto'), // Menu principal
        'footer' => __('Menu Footer', 'motaphoto'), // Menu footer
    ));
}
add_action('after_setup_theme', 'motaphoto_register_menus');

// Ajouter le support des images mises en avant
add_theme_support('post-thumbnails');

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

// Enregistrer les styles pour la page "Photo"
function motaphoto_enqueue_single_photo_styles() {
    if (is_singular('photo')) {
        wp_enqueue_style('single-photo-style', get_template_directory_uri() . '/assets/css/single-photo.css');
    }
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_single_photo_styles');

// Ajouter des tailles d'image personnalisées
add_action('after_setup_theme', function() {
    add_image_size('photo-large', 563, 844, true); // Taille de la grande photo
    add_image_size('photo-thumbnail', 81, 71, true); // Taille des miniatures
});



















