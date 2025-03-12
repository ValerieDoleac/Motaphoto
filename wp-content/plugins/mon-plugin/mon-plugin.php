<?php
/**
 * Plugin Name: Mon Plugin
 * Plugin URI :http://localhost/Motaphoto
 * Description: Ce plugin ajoute des fonctionnalités personnalisées à mon site.
 * Version: 1.0
 * Author: Doleac Valerie
 * Text Domain: mon-plugin
 * License: GPL2
 */

// Empêche l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

// Contenu personnalisé pour les articles de blog pour plus tard
function mon_plugin_register_blog_post_type() {
    $labels = array(
        'name'               => 'Articles de blog',
        'singular_name'      => 'Article de blog',
        'menu_name'          => 'Blog',
        'name_admin_bar'     => 'Article de blog',
        'add_new'            => 'Ajouter un article',
        'add_new_item'       => 'Ajouter un nouvel article de blog',
        'edit_item'          => 'Modifier l\'article',
        'new_item'           => 'Nouvel article',
        'view_item'          => 'Voir l\'article',
        'search_items'       => 'Rechercher des articles',
        'not_found'          => 'Aucun article trouvé',
        'not_found_in_trash' => 'Aucun article trouvé dans la corbeille',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'blog'),
        'menu_icon'          => 'dashicons-edit',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author'),
        'show_in_rest'       => true, // Active Gutenberg.
    );

    register_post_type('blog', $args);
}
add_action('init', 'mon_plugin_register_blog_post_type');

// Associe les catégories et tags natifs au type de contenu "Blog"
function mon_plugin_associate_taxonomies_with_blog() {
    register_taxonomy_for_object_type('category', 'blog');
    register_taxonomy_for_object_type('post_tag', 'blog'); // Étiquettes
}
add_action('init', 'mon_plugin_associate_taxonomies_with_blog');

// Associe la taxonomie "Format" au type de contenu personnalisé "Photo"
function associate_format_with_photos() {
    if (taxonomy_exists('format')) {
        register_taxonomy_for_object_type('format', 'photo');
    }
}
add_action('init', 'associate_format_with_photos');

