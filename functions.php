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
        'primary' => __('Menu Principal', 'motaphoto'),
    ));
}
add_action('after_setup_theme', 'motaphoto_register_menus');










