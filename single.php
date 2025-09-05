<?php get_header(); ?>

<main class="site-content">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    Publié le <?php the_time('j F Y'); ?> par <?php the_author(); ?>
                </div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            </article>
            
            <?php comments_template(); ?>
            
        <?php endwhile;
    else : ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
