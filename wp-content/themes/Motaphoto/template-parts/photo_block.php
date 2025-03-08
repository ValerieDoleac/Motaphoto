<?php
// Vérifie que $photo_id est bien défini
if (!isset($photo_id)) {
    return; // N'affiche rien si $photo_id n'est pas défini
}

// Récupère les détails de l'image
$image_url = wp_get_attachment_url(get_post_thumbnail_id($photo_id));
$large_url = wp_get_attachment_image_url($photo_id, 'full');
$photo_title = get_the_title($photo_id);
$categories = get_the_terms($photo_id, 'category');
$category_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : 'Non spécifié';

// Récupérer la taille de l'image
$image_data = wp_get_attachment_metadata(get_post_thumbnail_id($photo_id));
$image_width = $image_data['width'];
$image_height = $image_data['height'];

// Vérifier l'orientation pour ajouter une classe spécifique
$orientation_class = ($image_width > $image_height) ? 'landscape' : 'portrait';

?>

<div class="photo-item <?php echo esc_attr($orientation_class); ?>" 
    data-id="<?php echo esc_attr($photo_id); ?>" 
    data-title="<?php echo esc_attr($photo_title); ?>" 
    data-src="<?php echo esc_url($image_url); ?>" 
    data-category="<?php echo esc_attr($category_name); ?>">

    <div class="photo-image">
        <a href="<?php echo get_permalink($photo_id); ?>" class="open-lightbox">
            <img src="<?php echo esc_url($image_url); ?>"
                alt="<?php echo esc_attr($photo_title); ?>" 
                class="photo-thumbnail">
        </a>
    </div>
    <div class="photo-overlay">
        <div class="photo-details">
            <h3 class="photo-title"><?php echo esc_html($photo_title); ?></h3>
            <p class="photo-category"><?php echo esc_html($category_name); ?></p>
        </div>
        <div class="photo-icons">
            <a href="<?php echo get_permalink($photo_id); ?>" class="icon eye-icon"
                data-large="<?php echo esc_url($large_url); ?>"
                data-title="<?php echo esc_attr($photo_title); ?>"
                data-category="<?php echo esc_attr($category_name); ?>"
                title="Infos">👁️</a>
            <a href="#" 
                class="icon fullscreen-icon" 
                data-large="<?php echo esc_url($large_url); ?>"
                data-title="<?php echo esc_attr($photo_title); ?>"
                data-category="<?php echo esc_attr($category_name); ?>"
                title="Plein écran">⛶</a>
        </div>
    </div>
</div>



