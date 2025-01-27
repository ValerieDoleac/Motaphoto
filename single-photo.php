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
				<div class="photo-details" style="width: 50%;">
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
				</div>
				<div class="photo-main" style="width: 50%;">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('photo-large', ['style' => 'max-width: 100%; height: auto;']); ?>
					<?php else : ?>
						<p>Aucune image mise en avant.</p>
					<?php endif; ?>
				</div>
				
			</section>

			<!-- Section 2 : Interactions -->
			<section class="photo-interaction-section">
    <!-- Phrase et bouton -->
    <div class="photo-call-to-action">
        <p>Cette photo vous intéresse ?</p>
        <button class="open-modal" onclick="openContactModal('<?php echo get_post_meta(get_the_ID(), 'référence', true); ?>')">Contact</button>
    </div>
    <!-- Carrousel -->
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


			<!-- Section 3 : Suggestions -->
			<section class="photo-suggestions-section">
				<h3>VOUS AIMEREZ AUSSI</h3>
				<div class="suggestions-grid">
					<?php
					$suggested_photos = new WP_Query(array(
						'post_type' => 'photo',
						'posts_per_page' => 2,
						'post__not_in' => array(get_the_ID()),
					));
					if ($suggested_photos->have_posts()) :
						while ($suggested_photos->have_posts()) : $suggested_photos->the_post(); ?>
							<div class="suggestion-item">
								<a href="<?php the_permalink(); ?>">
									<?php if (has_post_thumbnail()) : ?>
										<?php the_post_thumbnail('medium', ['class' => 'suggestion-image', 'style' => 'width: 100%; height: auto;']); ?>
									<?php endif; ?>
								</a>
							</div>
						<?php endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</section>
		</main>
	<?php endwhile;
endif;

get_footer();




