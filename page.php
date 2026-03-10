<?php get_header(); ?> <!-- Inclusion de l’en-tête du site -->

<!-- ======================== HERO ========================--> 
<?php
// Création d'une requête personnalisée avec WP_Query
// Pour récupérer le type de contenue personnalisé "photo"
$hero_query = new WP_Query([
    'post_type'      => 'photo',    // type de contenu : CPT "photo"
    'posts_per_page' => 1,          // on récupère seulement 1 photo
    'orderby'        => 'rand'      // la photo est choisie aléatoirement
]);

$hero_image = '';   // variable qui servira à stocker l’URL de l’image
 
if ( is_front_page() ) : 

if ($hero_query->have_posts()) {        // Vérifie si la requête retourne au moins un résultat

    while ($hero_query->have_posts()) { // Boucle sur le résultat trouvé
        $hero_query->the_post();
        
        $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Récupère l'URL de l'image mise en avant du contenu
                                                               // en taille "full" pour l'utiliser dans le hero
        }
     // Réinitialise les données globales de WordPress
     // après l'utilisation d'une requête personnalisée
    wp_reset_postdata();
}
 endif; 
?>
<main class="site-content">
    <?php  
    /* Boucle WordPress : vérifie s’il existe du contenu à afficher */
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?> 

            <!-- Conteneur de la page avec classes dynamiques WordPress -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 

                <!-- Titre de la page n'est pas affiché -->
            <!-- <h1 class="page-title">  <?php the_title(); ?>  </h1>  -->

                <!-- Contenu principal de la page  -->
                <div class="page-content">
                    <?php the_content(); ?>                    
                </div>
            </article> 

        <?php endwhile;
    else : ?>
        <!-- Message affiché si aucun contenu n’est trouvé -->
        <p>Aucun contenu trouvé.</p>
    <?php endif; ?>
</main>

<!-- Affichage du hero avec l'image récupérée dynamiquement -->
<section class="hero" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
    <h1 class="hero-title">Photographe event</h1>
</section>



<?php get_footer(); ?> <!-- Inclusion du pied de page -->

