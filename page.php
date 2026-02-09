<?php get_header(); ?> <!-- Inclusion de l’en-tête du site -->

<main class="site-content">
    <?php  
    /* Boucle WordPress : vérifie s’il existe du contenu à afficher */
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?> 

            <!-- Conteneur de la page avec classes dynamiques WordPress -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 

                <!-- Titre de la page désactivé volontairement pour l’instant -->
                <!-- <h1 class="page-title"><?php the_title(); ?></h1> -->

                <!-- Contenu principal de la page (éditeur WordPress) -->
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

<?php get_footer(); ?> <!-- Inclusion du pied de page -->

