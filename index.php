<?php get_header(); ?>

<main class="content-area">

    <?php if (have_posts()): ?>
        <div class="posts-loop">
            <?php while (have_posts()): the_post(); ?>
                <article class="post-card">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                    <?php if (has_post_thumbnail()): ?>
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                            </a>
                        </div>
                    <?php endif; ?>

                    <p><?php the_excerpt(); ?></p>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else: ?>
        <p>No hay contenido disponible.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
