<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
    <!-- Logo -->
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo">
        </a>
    </div>

    <!-- Bouton Hamburger -->
    <button class="hamburger" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Menu -->
    <nav class="menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'nav_menu', // Classe CSS partagée
            'fallback_cb' => false
        ));
        ?>
    </nav>
</header>


<?php wp_footer(); ?>
</body>
</html>







