<?php
// $photo_id est défini dans le fichier page.php
if (!isset($photo_id)) {
    return; // N'afficher rien si $photo_id n'est pas défini
}

// Récupérer les détails de l'image
$image_url = wp_get_attachment_url(get_post_thumbnail_id($photo_id));
$image_html = get_the_post_thumbnail($photo_id, 'photo-thumbnail', array('class' => 'suggestion-image'));
$photo_title = get_the_title($photo_id);
$categories = get_the_terms($photo_id, 'category');
$category_name = $categories ? $categories[0]->name : 'Non spécifié';
?>


<div class="photo-item">
    <div class="photo-image">
        <a href="<?php echo get_permalink(); ?>">
            <?php echo get_the_post_thumbnail(get_the_ID(), 'photo-thumbnail'); ?>
        </a>
    </div>
    <div class="photo-overlay">
        <div class="photo-details">
            <h3 class="photo-title"><?php the_title(); ?></h3>
            <p class="photo-category">
                <?php
                $categories = get_the_terms(get_the_ID(), 'category');
                if ($categories && !is_wp_error($categories)) {
                    echo $categories[0]->name;
                }
                ?>
            </p>
        </div>
        <div class="photo-icons">
            <a href="<?php echo get_permalink(); ?>" class="icon eye-icon" title="Voir les infos">👁️</a>
            <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="icon fullscreen-icon" target="_blank" title="Plein écran">⛶</a>
        </div>
    </div>
</div>
