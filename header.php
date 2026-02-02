<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="logo">
        <?php
        if ( function_exists('the_custom_logo') ) {
            the_custom_logo(); // affiche le logo choisi dans l’admin
        } else {
            // Si aucun logo défini, afficher le nom du site
            echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
    }
    ?>
    </div>

<!--Affiche le menu dans l'en-tête --> 
    <nav class="main-nav">
        <?php
        wp_nav_menu(array(      
            'theme_location' => 'main-menu', // celui déclaré dans functions.php
            'container'      => false,       // pas de <div> supplémentaire
            'menu_class'     => 'menu',      // classe CSS pour le <ul>
        ));
        ?>
     </nav>
</header>

