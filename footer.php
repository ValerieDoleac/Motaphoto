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

    <?php get_template_part('template-parts/contact-modal'); ?>
    <?php wp_footer(); ?>



