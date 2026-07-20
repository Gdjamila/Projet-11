<?php get_header(); ?>

<main class="single-photo">
   <!--  Vérifie s'il existe au moins un contenu à afficher -->
    <?php if ( have_posts() ) : 
      // tant qu'il y a un contenu
      while ( have_posts() ) : // Tant qu'il y a des contenus, on les parcourt un par un
        
        the_post(); ?> <!-- charge les données de la photo courante -->
     
         <article class="photo-content">
                                    
            <!-- Informations de la photo (champs personnalisés) -->

           <!-- 👇 // (1) A gauche 50 % ,  Informations de la photo : bloc gauche -->
            <div class="photo-details">
               
               <div class="photo-details-content">
               
                  <h1 class="photo-title">
                     <?php the_title(); ?>
                  </h1>

                  <div class="photo-meta">
                     
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
                           echo esc_html( $terms[0]->name );  }  ?>
                     </p>

                     <p class="photo-type">
                        Type :  <?php echo esc_html( get_field('type') ); ?>
                     </p>
                     <p class="photo-date">
                        Année : <?php echo get_the_date('Y'); ?>
                     </p>

                  </div>

                  <!-- Référence de la photo utilisée pour le préremplissage du formulaire de contact -->
                  <div id="photo-ref"
                     data-photo-ref="<?php echo esc_attr( get_field('reference') ); ?>"> 
                  </div>

               </div>
            </div>

            <!-- 👇 // (2) A gauche 50 %--> <!-- Image de la photo : bloc droit -->
            <div class="photo-image">
               <?php the_post_thumbnail('large'); ?> <!-- Correspond à une taille d’image WordPress -->
            </div>

         </article>
             
         <!-- =============== Navigation entre les photos ====================== -->

         <!-- Bloc bas : contact et navigation -->
         <div class="photo-actions">

            <!-- Zone contact -->
            <div class="photo-contact">

               <h2 class="photo-contact-text">
                  Cette photo vous intéresse ?
               </h2>

               <button 
                  class="open-contact-modal photo-contact-button"
                  data-photo-ref="<?php echo esc_attr( get_field('reference') ); ?>">
                  Contact
               </button>
            </div>

               <!--Récupération des photos précédente et suivante 
                  utilisées pour la navigation et la miniature au survol -->
               <?php                  
                  $previous_photo = get_previous_post();                
                  $next_photo = get_next_post();
               ?>

               <?php

                  // URL de la miniature de la photo précédente
                  $previous_thumbnail = $previous_photo
                     ? get_the_post_thumbnail_url($previous_photo->ID, 'thumbnail')
                     : '';

                  // URL de la miniature de la photo suivante
                  $next_thumbnail = $next_photo
                     ? get_the_post_thumbnail_url($next_photo->ID, 'thumbnail')
                     : '';
               ?>
              
            <!-- Zone navigation -->
            <div class="photo-actions-navigation">

               <!-- Miniature de prévisualisation -->
               <div class="photo-nav-thumbnail">

                  <?php if ( $next_thumbnail ) : ?>
                     <img
                        id="nav-thumbnail"
                        src="<?php echo esc_url( $next_thumbnail ); ?>"
                        alt="Miniature de navigation">

                  <?php endif; ?>
                                   
               </div>

               <!-- Flèches de navigation -->
               <div class="photo-nav-arrows">
                  
                  <div
                     class="photo-prev"
                     data-thumbnail="<?php echo esc_url( $previous_thumbnail ); ?>">
                     <?php previous_post_link('%link', '←'); ?>
                  </div>
                  
                  <div
                     class="photo-next"
                     data-thumbnail="<?php echo esc_url( $next_thumbnail ); ?>">

                     <?php next_post_link('%link', '→'); ?>
                  </div>
               </div>

            </div>
         </div>

      <?php endwhile; endif; ?>
   
    
   <!-- ========================== Zone des photos apparentées ========================== -->
    
   <section class="photos-related">
      <h2 class="photos-related-title">
         VOUS AIMEREZ AUSSI
      </h2>

      <?php
         // Récupère les catégories de la photo actuellement affichée
         $terms = get_the_terms( get_the_ID(), 'categorie' );

         // Vérifie qu’il existe bien des catégories
         if ( $terms && ! is_wp_error( $terms ) ) {

            // Récupère uniquement les ID des catégories
            $term_ids = wp_list_pluck( $terms, 'term_id' );

            // Arguments de la requête WP_Query
            $args = [
               // Type de contenu : Photo (CPT)
               'post_type'      => 'photo',

               // Nombre de photos apparentées à afficher
               'posts_per_page' => 2,

               // Exclut la photo actuellement affichée
               'post__not_in'   => [ get_the_ID() ],

               // Filtre par catégorie (photos de la même catégorie)
               'tax_query'      => [
               [
                  'taxonomy' => 'categorie',
                  'field'    => 'term_id',
                  'terms'    => $term_ids,
               ],
               ],
            ];

            // === Création de la requête personnalisée === //   
            
            $related_query = new WP_Query( $args );
            
            // Vérifie s’il y a des photos à afficher
            if ( $related_query->have_posts() ) {
      ?>
            <div class="related-photos-grid">

               <?php
                  // Boucle sur les photos apparentées
                  while ( $related_query->have_posts() ) {
                     $related_query->the_post();

               ?>                  
                  <article class="photo-item"> 
                     <!-- Inclusion du bloc photo réutilisable -->
                     <?php  get_template_part( 'template-parts/photo-block' );  ?>       
                  </article>
                     
                  <?php
                     }
                  ?>
            </div>
            <?php
              // Réinitialise les données globales de WordPress
              wp_reset_postdata();
            }
         }
            ?>
   
   </section>    
</main>

<?php get_footer(); ?>