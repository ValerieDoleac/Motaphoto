<?php
// Assurez-vous que $photo_id est défini avant d'inclure ce template
if (!isset($photo_id)) {
    return; // Ne rien afficher si $photo_id n'est pas défini
}

// Récupérer les détails de l'image
$image_url = wp_get_attachment_url(get_post_thumbnail_id($photo_id));
$image_html = get_the_post_thumbnail($photo_id, 'medium', array('class' => 'suggestion-image'));
$permalink = get_permalink($photo_id);
?>

<div class="suggestion-item">
    <a href="<?php echo $permalink; ?>" class="suggestion-link">
        <?php echo $image_html; ?>
    </a>
    <div class="overlay">
        <a href="<?php echo $permalink; ?>" class="icon eye-icon" title="Voir les infos">👁️</a>
        <a href="<?php echo $image_url; ?>" class="icon fullscreen-icon" target="_blank" title="Plein écran">⛶</a>
    </div>
</div>
