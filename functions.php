<?php
// Fonction pour charger les styles et scripts du thème
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

    // Charger le script principal JavaScript
    wp_enqueue_script(
        'motaphoto-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('jquery'), // Dépendance à jQuery
        filemtime(get_template_directory() . '/assets/js/script.js'),
        true // Chargement dans le footer
    );

    // Passe l'URL AJAX au script JavaScript
    wp_localize_script('motaphoto-script', 'motaphoto_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_assets');

// Charger les styles du bloc photo
function enqueue_photo_block_styles() {
    wp_enqueue_style(
        'photo-block-styles',
        get_template_directory_uri() . '/assets/css/photo_block.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/photo_block.css')
    );
}
add_action('wp_enqueue_scripts', 'enqueue_photo_block_styles');

// Configuration du thème (menus)
function motaphoto_theme_setup() {
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Menu principal', 'motaphoto'),
        'footer' => __('Footer', 'motaphoto'),
    ));
}
add_action('after_setup_theme', 'motaphoto_theme_setup');

// Charger le script et le style pour la lightbox
function enqueue_lightbox_script() {
    wp_enqueue_script(
        'lightbox-script',
        get_template_directory_uri() . '/assets/js/lightbox.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/lightbox.js'),
        true
    );

    wp_enqueue_style(
        'lightbox-style',
        get_template_directory_uri() . '/assets/css/lightbox.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/lightbox.css')
    );
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_script');

// Ajouter le type de contenu personnalisé "photo"
function motaphoto_register_photo_post_type() {
    $labels = array(
        'name'               => 'Photos',
        'singular_name'      => 'Photo',
        'menu_name'          => 'Photos',
        'name_admin_bar'     => 'Photo',
        'add_new'            => 'Ajouter une photo',
        'add_new_item'       => 'Ajouter une nouvelle photo',
        'edit_item'          => 'Modifier la photo',
        'new_item'           => 'Nouvelle photo',
        'view_item'          => 'Voir la photo',
        'all_items'          => 'Toutes les photos',
        'search_items'       => 'Rechercher des photos',
        'not_found'          => 'Aucune photo trouvée.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'photo'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'         => array('category', 'post_tag'),
    );
    register_post_type('photo', $args);
}
add_action('init', 'motaphoto_register_photo_post_type');

// Ajouter le support des fonctionnalités du thème
function motaphoto_theme_support() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    // Les tailles perso :
    add_image_size('photo-large', 563, 844, true);
    add_image_size('photo-thumbnail', 81, 71, true);
    add_image_size('photo-suggestion', 564, 495, true);
}
add_action('after_setup_theme', 'motaphoto_theme_support');

// Charger les styles spécifiques pour "photo"
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

// Fonction AJAX pour charger plus de photos
function motaphoto_load_more_photos() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 16; // Charge 16 photos par requête

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_id = get_the_ID();
            include locate_template('template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else :
        echo ''; // Si plus de photos, renvoie une chaîne vide
    endif;

    wp_die(); // Fin de l'exécution
}
add_action('wp_ajax_load_more_photos', 'motaphoto_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'motaphoto_load_more_photos'); // Pour les visiteurs non connectés




// Fonction AJAX pour filtrer les photos
function motaphoto_filter_photos() {
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    );

    if (!empty($_POST['filter_type']) && !empty($_POST['value'])) {
        if ($_POST['filter_type'] === 'CATÉGORIES') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_POST['value']),
                ),
            );
        } elseif ($_POST['filter_type'] === 'FORMATS') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_POST['value']),
                ),
            );
        }
    }

    if ($_POST['filter_type'] === 'TRIER PAR') {
        if ($_POST['value'] === 'date_desc') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($_POST['value'] === 'date_asc') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            include locate_template('template-parts/photo_block.php');
        }
    } else {
        echo '<p>Aucune photo trouvée.</p>';
    }

    wp_die();
}
add_action('wp_ajax_filter_photos', 'motaphoto_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'motaphoto_filter_photos');























