<?php
// Sécurité : empêcher l'accès direct
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/* Charger les styles et scripts du thème */
function mon_theme_enqueue_assets() {
    // Pour Charger le CSS principal
    wp_enqueue_style('mon-theme-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css') );

    // JS principal (chargé dans le footer)
    wp_enqueue_script(
        'mon-theme-scripts',
        get_template_directory_uri() . '/js/scripts.js',
        array(),
        filemtime(get_template_directory() . '/js/scripts.js'),
        true        // Pour de meilleures performances
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_assets');

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

// déclare un emplacement de menu dans le thème (le menu principal).
function mon_theme_register_menus() {
    register_nav_menus(array(
        'main-menu' => __( 'Menu principal', 'theme-perso' )
    ));
}
add_action('after_setup_theme', 'mon_theme_register_menus');

// Pour activer le support du logo personnalisé (sans contraintes de taille)
function mon_theme_supports() {
    add_theme_support('custom-logo', array(
        'flex-height' => true, 
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'mon_theme_supports');


