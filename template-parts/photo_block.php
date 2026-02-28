<!-- ========== Bloc d’affichage d’une photo apparentée ========== -->
 
<article class="photo-related-item">
  <!-- Lien vers la page de la photo -->
  <a href="<?php the_permalink(); ?>">

    <!-- Image mise en avant de la photo -->
    <?php the_post_thumbnail('medium'); ?>

    <!-- Titre de la photo -->
    <h3 class="photo-related-title"><?php the_title(); ?></h3>

  </a>
</article>
