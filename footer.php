<footer class="site-footer">
    
    <div class="footer-links">
        <a href="<?php echo get_permalink(get_page_by_path('mentions-legales')); ?>">
            MENTIONS LÉGALES
        </a>
        <a href="<?php echo get_permalink(get_page_by_path('vie-privee')); ?>">
            VIE PRIVÉE
        </a> 
        <a href="<?php echo get_permalink(get_page_by_path('tous-droits-reserves')); ?>">
            TOUS DROITS RÉSERVÉS
        </a>        
    </div>

</footer>    
    <!-- Inclusion de la modale, mais cachée par défaut -->
    <?php get_template_part('template-parts/modal', 'contact'); ?>

    <!-- Inclusion de la lightbox -->
    <?php get_template_part('template-parts/lightbox'); ?>
    
    <!-- Hook WordPress pour charger les scripts -->
    <?php wp_footer(); ?> 

</body>
</html>
  


