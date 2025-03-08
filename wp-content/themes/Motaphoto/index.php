<?php
get_header(); // Appelle le header

echo "<h1>Bienvenue sur mon site Motaphoto</h1>";

if (have_posts()) {
    while (have_posts()) {
        the_post();
        echo "<h2>" . get_the_title() . "</h2>";
        the_content();
    }
} else {
    echo "<p>Aucun contenu trouvé.</p>";
}

get_footer(); // Appelle le footer
?>

