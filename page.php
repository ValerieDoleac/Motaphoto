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

/* Start the Loop */
while ( have_posts() ) :
    the_post();

    // Afficher le contenu principal de la page
    get_template_part( 'template-parts/content/content-page' );

    // Section pour afficher les photos (par exemple : photos récentes)
    ?>
    <section class="homepage-photo-gallery">
        <h2>Photos récentes</h2>
        <div class="photo-grid">
            <?php
            // Requête pour récupérer les photos récentes
            $recent_photos = new WP_Query(array(
                'post_type' => 'photo',
                'posts_per_page' => 4, // Limité à 4 photos
            ));

            if ( $recent_photos->have_posts() ) :
                while ( $recent_photos->have_posts() ) : $recent_photos->the_post();
                    include locate_template( 'template-parts/photo_block.php' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Aucune photo récente disponible.</p>';
            endif;
            ?>
        </div>
    </section>
    <?php

    // Si les commentaires sont ouverts ou s'il y a au moins un commentaire
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }

endwhile; // Fin de la boucle.

get_footer();
