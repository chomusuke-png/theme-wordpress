<?php get_header(); ?>

<?php if (is_home() && !is_paged()) : ?>
    <?php
    $slider_query = new WP_Query([
        'posts_per_page' => 3,       // Mostramos 3 posts
        'ignore_sticky_posts' => 1   // Ignoramos los fijados para que sea cronológico
    ]);
    ?>

    <?php if ($slider_query->have_posts()) : ?>
        <section class="hero-slider swiper">
            <div class="swiper-wrapper">
                <?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
                    <div class="swiper-slide" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'large'); ?>');">
                        <div class="slide-content">
                            
                            <div class="chips-container" style="justify-content: center; margin-bottom: 15px;">
                                <?php
                                // 1. Mostrar Categorías
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $cat) {
                                        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="chip chip-category">';
                                        // Icono opcional, puedes quitar la etiqueta <i> si prefieres solo texto
                                        echo '<i class="fa-solid fa-folder-open"></i> ' . esc_html($cat->name);
                                        echo '</a>';
                                    }
                                }

                                // 2. Mostrar Tags (Opcional: Si quieres tags también en el slider)
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="chip chip-tag" style="color: white; border-color: white;">'; 
                                        // Nota: Puse estilo blanco forzado para que el chip 'outline' se vea bien sobre la foto oscura
                                        echo '<i class="fa-solid fa-tag"></i> ' . esc_html($tag->name);
                                        echo '</a>';
                                    }
                                }
                                ?>
                            </div>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <a href="<?php the_permalink(); ?>" class="btn-slide">Leer más</a>
                        </div>
                        <div class="slide-overlay"></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </section>
        <?php wp_reset_postdata(); ?> <?php endif; ?>
<?php endif; ?>


<main class="content-area">
    <h3 class="section-title">Últimas Publicaciones</h3>
    
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
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p>
                    </div>
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