<?php
// Sécurité : empêcher l'accès direct
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/* ==================== Charge les styles et scripts du thème ====================  */

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

/* === Script gérant le chargement dynamique des photos via Ajax (pagination infinie)  === */

    wp_enqueue_script(
        'load-more',
        get_template_directory_uri() . '/js/load-more.js', 
        array('jquery'),
        null,
        true
    );
    // Passage de données PHP vers JS 
    wp_localize_script('load-more', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

 /* === Script gérant le chargement la lightbox  === */
    wp_enqueue_script(
        'lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array(),
        null,
        true
    );
   
 /* === Script de navigation entre les photos, (miniature au survol des flèches précédente/suivante) === */
    wp_enqueue_script( 
        'photo-navigation',
        get_template_directory_uri() . '/js/photo-navigation.js',
        array(),
        null,
        true
    );

    }
    
// Hook WordPress pour charger les scripts et styles du thème
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_assets');


// === Fonction appelée en Ajax pour charger plus de photos === //

function load_more_photos() {

    // Vérifie si le numéro de page est envoyé en Ajax, sinon utilise 1 par défaut
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Récupère les valeurs envoyées par Ajax
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format   = isset($_POST['format']) ? $_POST['format'] : '';
    $sort     = isset($_POST['sort']) ? $_POST['sort'] : '';

     // Construction des filtres taxonomiques
    $tax_query = [];

    if (!empty($category)) {
        $tax_query[] = [
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if (!empty($format)) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        ];
    }

    // Gestion du tri
    $order = 'DESC';

    if ($sort === 'date_asc') {
        $order = 'ASC';
    }

    // Arguments de la requête
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => $order,
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>   
         
            <!-- Réutilisation du template part existant -->
            <article class="photo-item">
                <?php get_template_part('template-parts/photo-block'); ?> 
            </article>
      <?php  endwhile;
    endif;
    
    wp_reset_postdata();    // Réinitialise les données WordPress après WP_Query

    // Transmet le nombre total de pages au script Ajax
    echo '<span class="max-pages" data-max="' . $query->max_num_pages . '"></span>';
    
    wp_die(); // Stoppe l'exécution après la réponse Ajax 
     
}

// Hooks Ajax (connecté + non connecté)
add_action('wp_ajax_load_more', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more', 'load_more_photos');

// Support du titre automatique dans <title>
add_theme_support( 'title-tag' );

// Support des images mises en avant
add_theme_support( 'post-thumbnails' );

// ==================== le menu principal ==================== 

// déclare un emplacement de menu dans le thème .
function mon_theme_register_menus() {
    register_nav_menus(array(
        'main-menu' => __( 'Menu principal', 'theme-perso' )
    ));
}
add_action('after_setup_theme', 'mon_theme_register_menus');

// ======================== le logo ======================== 

// Pour activer le support du logo personnalisé (sans contraintes de taille)
function mon_theme_supports() {
    add_theme_support('custom-logo', array(
        'flex-height' => true, 
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'mon_theme_supports');

?> 








