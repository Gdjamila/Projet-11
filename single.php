<?php get_header(); ?> <!-- Inclusion de l’en-tête du site -->

<main class="site-content">
    <?php
    /* Boucle WordPress : permet d’afficher un article individuel */
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>            

            <!-- Conteneur principal de l’article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <!-- Titre de l’article -->
                <h1 class="post-title"><?php the_title(); ?></h1>

                <!-- Métadonnées de l’article : date de publication et auteur -->
                <div class="post-meta">
                    Publié le <?php the_time('j F Y'); ?> par <?php the_author(); ?>
                </div>

                <!-- Contenu principal de l’article -->
                <div class="post-content">
                    <?php the_content(); ?>
                </div>

            </article>            

            <!-- Chargement du système de commentaires WordPress -->
            <?php comments_template(); ?>   

        <?php endwhile;
    else : ?>
        <!-- Message affiché si aucun article n’est trouvé -->
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?> <!-- Inclusion du pied de page -->

