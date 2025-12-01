<?php get_header(); ?>

<div class="archive-main-wrapper">

    <div class="archive-header">
        <div class="archive-header-content">
            <span class="archive-subtitle">Explorando</span>
            <?php
                the_archive_title('<h1 class="archive-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </div>
    </div>

    <main class="content-area">
        <div class="archive-container">
            
            <?php if (have_posts()): ?>
                <div class="posts-loop">
                    <?php while (have_posts()): the_post(); ?>
                        
                        <article class="post-card">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <?php
                                $cats = get_the_category();
                                if ($cats) {
                                    echo '<span class="mini-cat">' . esc_html($cats[0]->name) . '</span>';
                                }
                                ?>
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more-link">Leer artículo &rarr;</a>
                            </div>
                        </article>

                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php the_posts_pagination([
                        'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                        'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                    ]); ?>
                </div>

            <?php else: ?>
                <p style="text-align: center; padding: 50px;">No se encontraron artículos en esta sección.</p>
            <?php endif; ?>
            
        </div>
    </main>

</div>

<?php get_footer(); ?>