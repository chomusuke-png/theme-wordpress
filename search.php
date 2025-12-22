<?php get_header(); ?>

<div class="archive-main-wrapper">

    <div class="archive-header">
        <div class="archive-header-content">
            <span class="archive-subtitle">Resultados de búsqueda para:</span>
            <h1 class="archive-title">"<?php echo get_search_query(); ?>"</h1>
            <div class="archive-description">
                Encontramos <?php echo $wp_query->found_posts; ?> coincidencias
            </div>
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
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <?php if (get_post_type() === 'page') : ?>
                                    <span class="mini-cat" style="color: #666;">Página</span>
                                <?php else : ?>
                                    <?php
                                    $cats = get_the_category();
                                    if ($cats) {
                                        echo '<span class="mini-cat">' . esc_html($cats[0]->name) . '</span>';
                                    }
                                    ?>
                                <?php endif; ?>

                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more-link">Ver más &rarr;</a>
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
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 3rem; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #666;">No encontramos nada que coincida con tu búsqueda.</h3>
                    <p>Intenta con otras palabras clave.</p>
                </div>
            <?php endif; ?>
            
        </div>
    </main>

</div>

<?php get_footer(); ?>