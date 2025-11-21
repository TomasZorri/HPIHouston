<?php get_header(); ?>

<main id="main-content">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="post-list">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="post">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="post-meta">Publicado el <?php the_time('F j, Y'); ?> por <?php the_author(); ?></p>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="read-more">Leer más</a>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p>No hay entradas disponibles.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
