<!-- ========== Bloc d’affichage d’une photo apparentée ========== -->
<div>
<div class="photo-related-item">

  <!-- Lien vers la page de la photo (avec le click sur la photo
  <a href= "<?php /*the_permalink(); */?>"> -->

    <!-- Image mise en avant de la photo -->
    <?php the_post_thumbnail('medium'); ?>

    <!-- Titre de la photo  
     <h3 class="photo-related-title"><? /*php the_title(); */ ?></h3>-->
  </a>

  <!-- Icône œil : accès à la page photo -->
  <a
      href="<?php the_permalink(); ?>"
      class="photo-eye"
      aria-label="Voir les informations de la photo"> <!-- Pour l'accessibilité -->
      <span class="eye-icon" aria-hidden="true"></span>
  </a>

  <!--========== Bouton icône plein écran : ouverture lightbox ==========-->
  <button
      class="open-lightbox"
      aria-label="Ouvrir la lightbox"
      data-image="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
      data-reference="<?php echo esc_attr(get_field('reference')); ?>"
      data-title="<?php echo esc_attr(get_the_title()); ?>"
      data-category="<?php 
        $categories = get_the_terms(get_the_ID(), 'categorie');

        if ($categories && !is_wp_error($categories)) {
          echo esc_attr($categories[0]->name);
        }
      ?>" 
     >
      <span class="fullscreen-icon" aria-hidden="true"></span>
  </button>   

</div>



