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
                <h2><?php echo nl2br(wordwrap(get_the_title(), 10, "\n")); ?></h2>
                <p>RÉFÉRENCE : <?php echo get_post_meta(get_the_ID(), 'référence', true) ?: 'Non spécifiée'; ?></p>
                <p>CATEGORIE :
                    <?php 
                    $categories = get_the_terms(get_the_ID(), 'category');
                    if ($categories && !is_wp_error($categories)) {
                        foreach ($categories as $category) {
                            echo '<a href="' . get_term_link($category) . '">' . $category->name . '</a>';
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
                            echo '<a href="' . get_term_link($format) . '">' . $format->name . '</a>';
                        }
                    } else {
                        echo 'Non spécifié';
                    }
                    ?>
                </p>
                <p>TYPE : <?php echo get_post_meta(get_the_ID(), 'type', true) ?: 'Non spécifié'; ?></p>
                <p>ANNÉE : <?php echo get_post_meta(get_the_ID(), 'annee', true) ?: 'Non spécifiée'; ?></p>

                <!-- Trait -->
                <div class="trait1"></div>

            </div>
            <div class="photo-main">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('photo-large'); ?>
                <?php else : ?>
                    <p>Aucune image mise en avant.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section 2 : Interactions -->
        <section class="photo-interaction-section">
            <div class="photo-call-to-action">
                <p>Cette photo vous intéresse ?</p>
                <button class="open-modal" onclick="openContactModal('<?php echo get_post_meta(get_the_ID(), 'référence', true); ?>')">Contact</button>
            </div>
            <div class="photo-carousel">
                <div class="carousel-images">
                    <?php
                    $gallery_images = get_attached_media('image', get_the_ID());
                    if ($gallery_images) {
                        foreach ($gallery_images as $image) {
                            echo wp_get_attachment_image($image->ID, 'photo-thumbnail', array('class' => 'carousel-thumbnail'));
                        }
                    } else {
                        echo '<p>Aucune miniature disponible.</p>';
                    }
                    ?>
                </div>
                <div class="carousel-navigation">
                    <button class="prev-button">←</button>
                    <button class="next-button">→</button>
                </div>
            </div>
        </section>

        <!-- Trait -->
        <div class="trait2"></div>

        <!-- Section 3 : Suggestions -->
        <section class="photo-suggestions-section">
            <h3>VOUS AIMEREZ AUSSI</h3>
            <div class="suggestions-grid">
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
                        // Inclure le template pour chaque photo suggérée
                        $photo_id = get_the_ID();
                        include locate_template('template-parts/photo_block.php');
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p>Aucune photo disponible.</p>
                <?php endif; ?>
            </div>
        </section>

    </main>
    <?php endwhile;
endif;

get_footer();




