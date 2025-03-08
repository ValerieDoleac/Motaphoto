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
    <!-- Bouton Fermer -->
    <button class="lightbox-close">&times;</button> 

    <div class="lightbox-container">
        <!-- Image + Navigation -->
        <div class="lightbox-main">
            
            <button class="lightbox-prev">← Précédente</button> 
            <div class="lightbox-image-wrapper">
                <img id="lightbox-image" src="" alt="Image en plein écran">
            </div>
            <button class="lightbox-next">Suivante →</button>
            <div class="lightbox-text">
                <span class="lightbox-title"></span>
                <span class="lightbox-category"></span>
            </div>
        </div>
    </div>
</div>



<?php get_template_part('template-parts/contact-modal'); ?>
<?php wp_footer(); ?>
        </body>
    </html>



