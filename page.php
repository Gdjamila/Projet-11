<?php get_header(); ?> <!-- Inclusion de l’en-tête du site -->

<!-- ======================== HERO ========================-->

<?php
// Requête WP_Query pour récupérer une photo aléatoire du CPT "photo"
$hero_query = new WP_Query([
    'post_type'      => 'photo',    // type de contenu personnalisé
    'posts_per_page' => 1,          // nombre de photos à afficher
    'orderby'        => 'rand'      // la photo est choisie aléatoirement
]);

$hero_image = '';   // variable qui servira à stocker l’URL de l’image

// Vérifie si la requête retourne un résultat
if ($hero_query->have_posts()) {
    while ($hero_query->have_posts()) {
        $hero_query->the_post();
        // Récupère l'URL de l'image mise en avant du contenu dans sa taille originale "full" pour l'utiliser dans le hero
        $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
    // Réinitialise les données globales de WordPress après l'utilisation d'une requête personnalisée
    wp_reset_postdata();
}

?>
<main class="site-content">

    <!-- Hero affiché uniquement sur la page d'accueil -->
   <?php 
   if (is_front_page()) : ?>

        <!-- Affichage du hero avec l'image récupérée dynamiquement -->
        <section class="hero" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
            <h1 class="hero-title">Photographe event</h1>
        </section>   

    <!-- ====== La liste des photos du catalogue sur la page d’accueil ====== -->
    
    <section class="photo-catalog">
        <h2 class="catalog-title">Catalogue photos</h2>
    </section>  

    <!-- Structure la grille de photos -->
    <div class="photo-grid">

       <?php

        // Requête personnalisée pour récupérer les photos du CPT "photo"
        $photo_query = new WP_Query([
            'post_type'      => 'photo',    // type de contenu personnalisé
            'posts_per_page' => 8            // nombre de photos à afficher
        ]);

        // Vérifie si la requête retourne des photos
        if ($photo_query->have_posts()) :

            // Boucle sur les photos
           while ($photo_query->have_posts()) : $photo_query->the_post();
        ?>
                <!-- Affichage d'une photo -->
                <article class="photo-item">
                   <!-- Charge le template-part "photo-block" pour afficher chaque photo -->                  
                    <?php get_template_part('template-parts/photo-block'); ?>
                </article>
        <?php
            endwhile;

            // Réinitialise les données WordPress
            wp_reset_postdata();

         else :
        ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    <?php endif; ?>  
    </div>
  <!--  Gestion du bouton avec Ajax (pagination infinie) --> 
    <div class="load-more-container">
        <button id="load-more">Charger plus</button>
    </div>

    <!-- ====== Boucle principale WordPress : affichage du contenu de la page ====== -->
    
    <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
    
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!--Le titre de la page est désactivé -->
        <!-- <h1 class="page-title"><?php the_title(); ?></h1> -->

            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; else :  ?>
        <p>Aucun contenu trouvé.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?> <!-- Inclusion du pied de page -->