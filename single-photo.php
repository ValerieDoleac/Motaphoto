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

if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <main id="site-content" class="single-photo-template">

        <!-- Section 1 : Informations et grande image -->
        <section class="photo-info-section">
        <div class="photo-details">
            <h2><?php the_title(); ?></h2>
            <p>RÉFÉRENCE : <span class="reference"><?php echo get_post_meta(get_the_ID(), 'reference', true) ?: 'Non spécifiée'; ?></span></p>
            <p>CATÉGORIE :
            <?php 
                $categories = get_the_terms(get_the_ID(), 'category');
                if ($categories && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                    echo '<span>' . $category->name . '</span> ';
                }
                } else {
                echo 'Non spécifiée';
                }
            ?>
            </p>
            <p>FORMAT :
            <?php 
                $formats = get_the_terms(get_the_ID(), 'format');
                if ($formats && !is_wp_error($formats)) {
                foreach ($formats as $format) {
                    echo '<span>' . $format->name . '</span> ';
                }
                } else {
                echo 'Non spécifié';
                }
            ?>
            </p>
            <p>TYPE : <?php echo get_post_meta(get_the_ID(), 'type', true) ?: 'Non spécifié'; ?></p>
            <p>DATE : <?php echo get_the_date(); ?></p>
            <div class="trait1"></div>
        </div>
        
        <!--  image "grand format" -->
        <div class="photo-main">
            <?php
            if (has_post_thumbnail()) {
            $feat_url = get_the_post_thumbnail_url(get_the_ID(), 'photo-large');
            ?>
            <img id="main-photo" src="<?php echo esc_url($feat_url); ?>" alt="">
            <?php
            } else {
            echo '<img id="main-photo" src="" alt="Pas d\'image pour l\'instant">';
            }
            ?>
            </div>
        </section>

        <!-- Section 2 : Interactions -->
        <section class="photo-interaction-section">
            <div class="photo-call-to-action">
                <p>Cette photo vous intéresse ?</p>
                <button class="open-modal" data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>">Contact</button>
            </div>

            <div class="photo-carousel">
                <div class="carousel-images">
                    <?php
                    $gallery_images = get_attached_media('image', get_the_ID());
                    if ($gallery_images) {
                        foreach ($gallery_images as $image) {
                            $large_url = wp_get_attachment_image_url($image->ID, 'photo-large');
                        
                            echo '<div class="carousel-item">';
                            echo wp_get_attachment_image($image->ID, 'photo-thumbnail', false, array(
                                'class' => 'carousel-thumbnail',
                                'data-large' => esc_url($large_url)
                            ));
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Aucune miniature disponible.</p>';
                    }
                    ?>
                </div>
                
                <!-- Navigation -->
                <div class="carousel-navigation">
                    <button class="prev-button" aria-label="Image précédente">←</button>
                    <button class="next-button" aria-label="Image suivante">→</button>
                </div>
            </div>

        </section>

        <div class="trait2"></div>

        <!-- Section 3 : Suggestions -->
        <section class="photo-gallery">
            <h3>VOUS AIMEREZ AUSSI</h3>
            <div class="photo-grid">
            <?php
            $current_categories = get_the_terms(get_the_ID(), 'category');
            $current_category_ids = $current_categories ? wp_list_pluck($current_categories, 'term_id') : array();

            $suggested_photos = new WP_Query(array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $current_category_ids,
                ),
            ),
        ));
        
            if ($suggested_photos->have_posts()) :
            while ($suggested_photos->have_posts()) : $suggested_photos->the_post();
                $photo_id = get_the_ID();
                include locate_template('template-parts/photo_block.php');
            endwhile;
            wp_reset_postdata();
            else :
            echo '<p>Aucune photo disponible.</p>';
            endif;
            ?>
        </div>
    </section>
    </main>
    <?php
    endwhile;
endif;

get_footer();





