<?php
get_header();

// Votre requête personnalisée pour afficher les photos
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 16,
);
$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <div class="photo-grid">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <?php
                // Vérifie si une image mise en avant existe et l'affiche, sinon affiche un placeholder
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium'); // Affiche la taille "medium" de l'image mise en avant
                } else {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg') . '" alt="Placeholder">';
                }
                ?>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php the_date(); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <!-- Pagination -->
    <?php
    echo paginate_links(array(
        'total' => $query->max_num_pages,
    ));
    ?>
<?php else : ?>
    <p>Aucune photo trouvée.</p>
<?php endif;

// Réinitialiser la requête
wp_reset_postdata();

get_footer();
?>


