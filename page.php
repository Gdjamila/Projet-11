<?php get_header(); ?> <!-- Inclusion de l’en-tête du site -->

<!-- ======================== HERO ========================-->

<?php
// Requête WP_Query pour récupérer une photo aléatoire du CPT "photo"
$hero_query = new WP_Query([
    'post_type'      => 'photo',    // type de contenu personnalisé
    'posts_per_page' => 1,          // nombre de photos à afficher
    'orderby'        => 'rand'      // la photo est choisie aléatoirement
]);

$hero_image = '';   // variable qui servira à stocker l’URL de l’image

// Vérifie si la requête retourne un résultat
if ($hero_query->have_posts()) {

    while ($hero_query->have_posts()) {
        $hero_query->the_post();

        // Récupère l'URL de l'image mise en avant du contenu dans sa taille originale "full" pour l'utiliser dans le hero
        $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
    // Réinitialise les données globales de WordPress après l'utilisation d'une requête personnalisée
    wp_reset_postdata();
}

?>
<!-- ============================== La zone de contenu ============================== -->

<main class="site-content">

    <!-- Hero affiché uniquement sur la page d'accueil -->
    <?php 
    if (is_front_page()) : ?>

        <!-- Affichage du hero avec l'image récupérée dynamiquement -->
        <section class="hero" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
            <h1 class="hero-title">Photographe event</h1>
        </section>   

        
       <!-- =========== Le filtre Catégories : Select d’origine utilisé pour la logique Ajax =========== -->
       
        <div class="container">

            <div class="inner-content">

                <div class="filters">

                    <select id="filter-category">
                
                        <!-- Option par défaut (aucun filtre sélectionné) -->
                        <option value="">Catégories</option>                        
                    
                        <?php
                        // Récupère toutes les catégories de la taxonomy "categorie"
                        $terms = get_terms(array(
                        'taxonomy' => 'categorie', // Nom de la taxonomy personnalisée
                        'hide_empty' => true, // N'affiche que les catégories contenant des photos
                        ));

                        // Boucle sur chaque catégorie récupérée
                        foreach ($terms as $term) : ?>

                            <!-- Génère une option pour chaque catégorie -->
                            <option value="<?php echo $term->slug; ?>">
                                <?php echo $term->name; ?> <!-- Nom affiché -->
                            </option>

                        <?php endforeach; ?>
                    </select> 
                    
                <!--=========== Le filtre Catégories : Custom select utilisé pour l’affichage visuel ===========  -->            
                    
                    <div class="custom-select" data-target="filter-category">

                        <!-- Affichage de la valeur sélectionnée -->
                        <div class="select-selected">Catégories</div>

                        <div class="select-options">

                            <!-- Option pour réinitialiser le filtre -->
                            <div data-value="" data-label="Catégories">&nbsp;</div>
                            <!-- <div data-value="" disabled selected hidden>Catégories</div> -->

                            <!-- Génère les options dynamiquement depuis WordPress -->
                            <?php foreach ($terms as $term) : ?>
                                <div data-value="<?php echo $term->slug; ?>">
                                    <?php echo $term->name; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
        
                <!--=========== Le filtre format: Select d’origine utilisé pour la logique Ajax =========== -->

                    <select id="filter-format">
                    
                        <!-- Option pour réinitialiser le filtre -->
                        <option value=""> Formats</option>
                                            
                        <?php
                        $terms = get_terms(array(   // Récupère les termes de la taxonomy afin d'alimenter dynamiquement le select
                            'taxonomy' => 'format', // Nom de la taxonomy personnalisée
                            'hide_empty' => true, // N'affiche que les formats utilisés par des photos
                        ));

                        // Boucle sur chaque format récupéré
                        foreach ($terms as $term) : ?>

                            <!-- Génère une option pour chaque format -->
                            <option value="<?php echo $term->slug; ?>">
                                <?php echo $term->name; ?> <!-- Nom lisible du format affiché dans la liste -->
                            </option>

                        <?php endforeach; ?>
                    </select>

                    <!--=========== Le filtre format: Custom select utilisé pour l’affichage visuel ===========-->

                    <div class="custom-select" data-target="filter-format">

                        <!-- Texte affiché -->
                        <div class="select-selected">Formats</div>

                        <div class="select-options">

                            <!-- Reset du filtre -->                            
                            <div data-value="" data-label="Formats">&nbsp;</div>

                            <!-- Options dynamiques -->
                            <?php foreach ($terms as $term) : ?>
                                <div data-value="<?php echo $term->slug; ?>">
                                    <?php echo $term->name; ?>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    
                    <!--======= le filtre Trier par : Select d’origine utilisé pour la logique Ajax ========== -->
                                
                    <select id="filter-sort">
                        <!-- Option pour réinitialiser le tri 
                        <option value=" ">Trier par</option> -->
                        <div data-value="" data-label="Trier">Trier</div>

                        <option value="date_desc">À partir des plus récentes</option>
                        <option value="date_asc">À partir des plus anciennes</option>
                    </select>                

                <!--======== le filtre 'Trier par': Custom select utilisé pour l’affichage visuel =========== -->

                    <div class="custom-select custom-sort" data-target="filter-sort">                

                        <!-- Texte affiché -->
                        <div class="select-selected">Trier par</div>

                        <div class="select-options">
                            
                            <!-- Reset du tri -->
                            <div data-value="" data-label="Trier">&nbsp;</div>

                            <div data-value="date_desc">À partir des plus récentes</div>
                            <div data-value="date_asc">À partir des plus anciennes</div>

                        </div>
                    </div>
                </div>   
            
             <!-- ======================== Structure la grille de photos ============= -->
            
                <div class="photo-grid">
                    
                    <?php

                        // Requête personnalisée pour récupérer les photos du CPT "photo"
                        $photo_query = new WP_Query([
                            'post_type'      => 'photo',    // type de contenu personnalisé
                            'posts_per_page' => 8            // nombre de photos à afficher
                        ]);

                        // Vérifie si la requête retourne des photos
                        if ($photo_query->have_posts()) :

                        // Boucle sur les photos
                        while ($photo_query->have_posts()) : $photo_query->the_post();
                    ?>
                            <!-- Affichage d'une photo -->
                            <article class="photo-item">
                                <!-- Charge le template-part "photo-block" pour afficher chaque photo -->                  
                                <?php get_template_part('template-parts/photo-block'); ?>
                            </article>
                        <?php
                        endwhile;

                            // Réinitialise les données WordPress
                            wp_reset_postdata();
                        else :  ?>
                            <p class="no-results">Aucune photo trouvée.</p>
                        <?php endif; ?>
                </div>
            </div> 
        </div>    

      <!-- ====== Gestion du bouton avec Ajax (pagination infinie) ====== --> 
    
        <div class="load-more-container">
            <button id="load-more">Charger plus</button>
        </div>    
    <?php endif; ?> 

     <!-- ====== Boucle principale WordPress : affichage du contenu de la page ====== -->

     <!-- Vérifie si la page contient du contenu puis démarre la boucle WordPress -->    
        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

             <!--Le titre de la page est désactivé -->
             <!-- <h1 class="page-title"><?php the_title(); ?></h1> -->

             <!-- Article représentant le contenu de la page courante -->
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; else :  ?>
            <p class="no-content">Aucun contenu trouvé.</p>
        <?php endif; ?>   
</main>

<?php get_footer(); ?> <!-- Inclusion du pied de page -->