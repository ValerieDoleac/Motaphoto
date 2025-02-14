<footer class="footer">
    <div class="footer_wrapper">
        <ul class="footer_content">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer', // Utilisation du menu dynamique
                'container' => false, // Pas de conteneur autour de la liste
                'menu_class' => 'footer_content',
                'depth' => 1 // Pas de sous-menus
            ));
            ?>
            <p>TOUS DROITS RESERVES</p>
        </ul>
    </div>
</footer>

<!-- Lightbox Overlay -->
<div id="lightbox-overlay" class="lightbox-overlay">
    <span class="lightbox-close">&times;</span> <!-- Bouton Fermer -->
    <button class="lightbox-prev">← Précédente</button>
    <button class="lightbox-next">Suivante →</button>
    <div class="lightbox-content">
        <img id="lightbox-image" src="" alt="Image en plein écran">
        <div class="lightbox-info">
            <span class="lightbox-title"></span>
            <span class="lightbox-category"></span>
        </div>
    </div>
</div>


    <?php get_template_part('template-parts/contact-modal'); ?>
    <?php wp_footer(); ?>



