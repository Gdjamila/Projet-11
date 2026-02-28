<?php get_header(); ?>

<main class="single-photo">
   <!--  Vérifie s'il existe au moins un contenu à afficher -->
    <?php if ( have_posts() ) : 
      // tant qu'il y a un contenu
      while ( have_posts() ) : // Tant qu'il y a des contenus, on les parcourt un par un
        
        the_post(); ?> <!-- charge les données de la photo courante -->
     
         <article class="photo-content">

            <div class="photo-image">
               <?php the_post_thumbnail('large'); ?> <!-- Correspond à une taille d’image WordPress -->
            </div>
            <!--======== Informations de la photo (champs personnalisés) ======== -->
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

   <!-- ====================== Navigation entre les photos ====================== -->
   <nav class="photo-navigation">

      <div class="photo-prev">
         <?php previous_post_link('%link', '← Photo précédente'); ?>
      </div>
      <div class="photo-next">
         <?php next_post_link('%link', 'Photo suivante →'); ?>
      </div>
   </nav>
    
   <!-- ========================== Zone des photos apparentées ========================== -->
    
   <section class="photos-related">
   <h2>Photos apparentées</h2>

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
      'posts_per_page' => 4,

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

    // ====== Création de la requête personnalisée ====== //
    $related_query = new WP_Query( $args );

    // Vérifie s’il y a des photos à afficher
    if ( $related_query->have_posts() ) {

      // Boucle sur les photos apparentées
      while ( $related_query->have_posts() ) {
        $related_query->the_post();

        // Inclusion du bloc photo réutilisable
        get_template_part( 'template-parts/photo_block' );
      }

      // Réinitialise les données globales de WordPress
      wp_reset_postdata();
    }
  }
  ?>
</section>    
</main>

<?php get_footer(); ?>