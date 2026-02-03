<?php get_header(); ?>

<main class="single-photo">
   <!--  Vérifie s'il existe au moins un contenu à afficher -->
    <?php if ( have_posts() ) : 
      // tant qu'il y a un contenu
      while ( have_posts() ) :
        // On charge les données de la photo courante
        the_post(); ?>

        <!-- Contenu de la photo -->
         <article class="photo-content">

            <div class="photo-image">
               <?php the_post_thumbnail('large'); ?> <!-- Correspond à une taille d’image WordPress -->
            </div>
            
            <div class="photo-infos">
               <h1 class="photo-title"><?php the_title(); ?></h1>

               <div class="photo-meta">
                  <?php the_content(); ?>
               </div>
               <button class="btn-contact" data-photo-ref="<?php echo esc_attr( get_the_title() ); ?>">
                  Contact
               </button>
            </div>

         </article>

   <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>