<?php
// Sécurité : empêcher l'accès direct
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Charger le fichier style.css
function mon_theme_enqueue_styles() {
    wp_enqueue_style(
        'mon-theme-style',
        get_stylesheet_uri()
    );
}
add_action( 'wp_enqueue_scripts', 'mon_theme_enqueue_styles' );

// Support du titre automatique dans <title>
add_theme_support( 'title-tag' );

// Support des images mises en avant
add_theme_support( 'post-thumbnails' );