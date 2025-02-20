<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */



get_header();

// Hero avec une image aléatoire
$random_photo = new WP_Query(array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand'
));
if ($random_photo->have_posts()) :
    while ($random_photo->have_posts()) : $random_photo->the_post(); ?>
        <section class="hero-section" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
            <h1>PHOTOGRAPHE EVENT</h1> <!-- Texte statique pour le titre -->
        </section>
    <?php endwhile;
    wp_reset_postdata();
endif;

/* début de la boucle Loop */
while (have_posts()) :
    the_post();

    // Contenu principal de la page
    get_template_part('template-parts/content/content-page');

    // Gestion commentaires
    if (comments_open() || get_comments_number()) {
        comments_template();
    }

endwhile; // Fin de la boucle ?>

<section class="filters-section">

    <div class="filters-box">
        <button  id="filter-categories" class="filter-toggle" aria-expanded="false">
            CATÉGORIES <span class="arrow">▼</span>
        </button>
        <ul class="filter-list" hidden>
            <li class="filter-item" data-filter-type="category" data-value="concert">Concert</li>
            <li class="filter-item" data-filter-type="category" data-value="mariage">Mariage</li>
            <li class="filter-item" data-filter-type="category" data-value="reception">Réception</li>
            <li class="filter-item" data-filter-type="category" data-value="television">Télévision</li>
        </ul>
    </div>

    <div class="filters-box">
        <button id="filter-formats" class="filter-toggle" aria-expanded="false">
            FORMATS <span class="arrow">▼</span>
        </button>
        <ul class="filter-list" hidden>
            <li class="filter-item" data-filter-type="format" data-value="portrait">Portrait</li>
            <li class="filter-item" data-filter-type="format" data-value="paysage">Paysage</li>
        </ul>
    </div>

    <div class="filters-box">
        <button id="filter-sort" class="filter-toggle" aria-expanded="false">
            TRIER PAR <span class="arrow">▼</span>
        </button>
        <ul class="filter-list" hidden>
            <li class="filter-item" data-filter-type="TRIER PAR" data-value="Plus récentes">Plus récentes</li>
            <li class="filter-item" data-filter-type="TRIER PAR" data-value="plus anciennes">Plus anciennes</li>
        </ul>
    </div>

</section>



<section class="photo-gallery">
    <div class="photo-grid">
        <!-- Les premières photos chargé ici -->
        <?php
        $recent_photos = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' => 8, // Les premières 8 photos
            'paged' => 1
        ));

        if ($recent_photos->have_posts()) :
            while ($recent_photos->have_posts()) : $recent_photos->the_post();
                // Définit $photo_id pour chaque photo
                $photo_id = get_the_ID();
                include locate_template('template-parts/photo_block.php');
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
    <div class="photo-gallery-controls">
        <button id="load-more" onClick="loadImage(16)" class="load-more-button">Charger plus</button>
    </div>
</section>

<?php
get_footer();


