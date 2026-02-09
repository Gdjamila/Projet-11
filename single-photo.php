<?php get_header(); ?>

<main class="single-photo">
   <!--  Vérifie s'il existe au moins un contenu à afficher -->
    <?php if ( have_posts() ) : 
      // tant qu'il y a un contenu
      while ( have_posts() ) :
        // On charge les données de la photo courante
        the_post(); ?>
     
         <article class="photo-content">

            <div class="photo-image">
               <?php the_post_thumbnail('large'); ?> <!-- Correspond à une taille d’image WordPress -->
            </div>
            <!-- Informations de la photo (champs personnalisés) -->
            <div class="photo-details">
               
               <h1 class="photo-title">
                  <?php the_title(); ?>
               </h1>
               <p class="photo-ref">
                  Réfenrence : <?php echo esc_html( get_field('reference') ); ?>
               </p>
          
               <p class="photo-category">
                Catégorie :
                 <?php
                  $terms = get_the_terms( get_the_ID(), 'categorie' );
                  if ( $terms && ! is_wp_error( $terms ) ) {
                     echo esc_html( $terms[0]->name ); } 
                  ?>
               </p>
               <p class="photo-format">
                Format :
               <?php  $terms = get_the_terms( get_the_ID(), 'format' );
               if ( $terms && ! is_wp_error( $terms ) ) {
                  echo esc_html( $terms[0]->name );  }  ?> </p>

               <p class="photo-type">
                  Type :  <?php echo esc_html( get_field('type') ); ?>
               </p>
               <p class="photo-date">
                  Année : <?php echo get_the_date('Y'); ?>
               </p>
               <div class="photo-description">
                  <?php the_content(); ?>
               </div>

               <!-- Référence de la photo utilisée pour le préremplissage du formulaire de contact -->
               <div id="photo-ref"
                  data-photo-ref="<?php echo esc_attr( get_field('reference') ); ?>"> 
               </div>
            </div>
         </article>
      <?php endwhile; endif; ?>

               <!-- Navigation entre les photos -->
               <nav class="photo-navigation">

                  <div class="photo-prev">
                     <?php previous_post_link('%link', '← Photo précédente'); ?>
                  </div>
                  <div class="photo-next">
                     <?php next_post_link('%link', 'Photo suivante →'); ?>
                  </div>
               </nav>
</main>

<?php get_footer(); ?>