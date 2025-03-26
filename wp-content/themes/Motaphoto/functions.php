<?php


function motaphoto_force_jquery() {
    if (!wp_script_is('jquery', 'enqueued')) { // Vérifie si jQuery est chargé
        wp_enqueue_script('jquery'); // Charge jQuery si ce n'est pas le cas
    }
}
add_action('wp_enqueue_scripts', 'motaphoto_force_jquery');


// Charger les styles et scripts du thème
function motaphoto_enqueue_assets() {
    // Charger les polices
    wp_enqueue_style(
        'motaphoto-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        array(),
        null
    );

    // Charger le style principal
    wp_enqueue_style(
        'motaphoto-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Charger le style du bloc photo
    wp_enqueue_style(
        'photo-block-styles',
        get_template_directory_uri() . '/assets/css/photo_block.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/photo_block.css')
    );

    // Charger jQuery
    wp_enqueue_script('jquery');

    // Charger le script principal JavaScript
    wp_enqueue_script(
        'motaphoto-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/script.js'),
        true
    );

    // Charger le script de la lightbox
    wp_enqueue_script(
        'lightbox-script',
        get_template_directory_uri() . '/assets/js/lightbox.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/lightbox.js'),
        true
    );

    // Charger le style de la lightbox
    wp_enqueue_style(
        'lightbox-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );

    // Passer l'URL AJAX à JavaScript
    wp_localize_script('motaphoto-script', 'motaphoto_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_assets');

function force_jquery_version() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.7.1.min.js', false, '3.7.1', true);
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'force_jquery_version', 1);


// Configuration du thème (menus)
function motaphoto_theme_setup() {
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Menu principal', 'motaphoto'),
        'footer'  => __('Footer', 'motaphoto'),
    ));
}
add_action('after_setup_theme', 'motaphoto_theme_setup');

// Ajouter le support des fonctionnalités du thème
function motaphoto_theme_support() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    // Définir les tailles d'image personnalisées
    add_image_size('photo-large', 563, 844, true);
    add_image_size('photo-thumbnail', 81, 71, true);
    add_image_size('photo-suggestion', 564, 495, true);
}
add_action('after_setup_theme', 'motaphoto_theme_support');


// Charger les styles spécifiques pour la page d'une photo
function motaphoto_enqueue_single_photo_styles() {
    if (is_singular('photo')) {
        wp_enqueue_style(
            'single-photo-style',
            get_template_directory_uri() . '/assets/css/single-photo.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/single-photo.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_single_photo_styles');


// Fonction AJAX pour charger plus de photos (pagination infinie)
function motaphoto_load_more_photos() {
    // recupere les parametres de la requete AJAX
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 16;
    // construction de la requête WP Query
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    );

    $query = new WP_Query($args); // Exécute la requête wordpress avec les paramètres

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_id = get_the_ID();
            include locate_template('template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else :
        echo ''; // Si plus de photos, renvoie une chaîne vide
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_photos', 'motaphoto_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'motaphoto_load_more_photos'); // Pour les visiteurs non connectés




// Fonction AJAX pour filtrer les photos

function motaphoto_filter_photos() {
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'DESC';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';

    $tax_query = array('relation' => 'AND'); // Assure que les filtres sont combinés

    if (!empty($categorie)) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }
// parametre de la requete wordpress wp query
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $sort,
        'tax_query'      => count($tax_query) > 1 ? $tax_query : '',
    );
// execute la requete wordpress
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_id = get_the_ID();
            include locate_template('template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_die();
}

add_action('wp_ajax_filter_photos', 'motaphoto_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'motaphoto_filter_photos');































