<?php get_header(); ?>

<?php if (is_home() && !is_paged()) : ?>
    
    <?php
    $slider_query = new WP_Query([
        'posts_per_page' => 3,
        'ignore_sticky_posts' => 1
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
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $cat) {
                                        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="chip chip-category">';
                                        echo '<i class="fa-solid fa-folder-open"></i> ' . esc_html($cat->name);
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
        <?php wp_reset_postdata(); ?> 
    <?php endif; ?>

    <section class="featured-categories">
        <div class="cat-container">
            <h3 class="section-title">Cosas que te pueden interesar</h3>
            <div class="cat-grid">
                <?php
                // Obtener todas las categorías con posts
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 4, // Mostrar las 4 más populares
                    'hide_empty' => true
                ));

                foreach ($categories as $category) :
                    // Intentamos obtener una imagen de un post de esta categoría para el fondo
                    $args = array(
                        'cat' => $category->term_id,
                        'posts_per_page' => 1,
                    );
                    $cat_post = new WP_Query($args);
                    $bg_image = '';
                    
                    if ($cat_post->have_posts()) {
                        while ($cat_post->have_posts()) {
                            $cat_post->the_post();
                            $bg_image = get_the_post_thumbnail_url(null, 'medium');
                        }
                    }
                    wp_reset_postdata();

                    // Si no hay imagen, usamos un color de fondo por defecto en CSS
                    $style_attr = $bg_image ? "style='background-image: url(\"$bg_image\");'" : "";
                ?>
                    <div class="cat-card" <?php echo $style_attr; ?>>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <i class="fa-solid fa-layer-group cat-icon"></i>
                            <h4><?php echo esc_html($category->name); ?></h4>
                            <p><?php echo $category->count; ?> Artículos</p>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="btn-cat">Ver más</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php endif; ?>

<main class="content-area">
    <div class="home-widgets-container">
        <?php if (is_active_sidebar('home-widgets')) : ?>
            <?php dynamic_sidebar('home-widgets'); ?>
        <?php else : ?>
            <p style="text-align:center; padding: 40px; color:#666;">
                Activa widgets en el área "Home Widgets" desde Apariencia > Widgets.
            </p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>