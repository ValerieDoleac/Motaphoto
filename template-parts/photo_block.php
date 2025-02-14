<?php
// Vérifie que $photo_id est bien défini
if (!isset($photo_id)) {
    return; // N'affiche rien si $photo_id n'est pas défini
}

// Récupère les détails de l'image
$image_url = wp_get_attachment_url(get_post_thumbnail_id($photo_id)); // URL de l'image
$large_url = wp_get_attachment_image_url($photo_id, 'full'); // URL en grande taille
$photo_title = get_the_title($photo_id); // Titre de la photo
$categories = get_the_terms($photo_id, 'category'); // Catégorie de la photo
$category_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : 'Non spécifié'; // Nom de la catégorie
?>

<div class="photo-item">
    <div class="photo-image">
        <a href="#" class="open-lightbox" 
            data-large="<?php echo esc_url($large_url); ?>" 
            data-title="<?php echo esc_attr($photo_title); ?>" 
            data-category="<?php echo esc_attr($category_name); ?>">
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
            <a href="#" class="icon eye-icon open-lightbox"
                data-large="<?php echo esc_url($large_url); ?>"
                data-title="<?php echo esc_attr($photo_title); ?>"
                data-category="<?php echo esc_attr($category_name); ?>"
                title="Voir en grand">👁️</a>
            <a href="<?php echo esc_url($large_url); ?>" 
                class="icon fullscreen-icon" 
                target="_blank" 
                title="Plein écran">⛶</a>
        </div>
    </div>
</div>

