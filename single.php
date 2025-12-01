<?php get_header(); ?>

<main class="single-main-wrapper">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>

            <?php if (has_post_thumbnail()) : ?>
                <div class="single-header has-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>');">
                    <div class="single-header-overlay"></div>
                    <div class="single-header-content">
                        <div class="single-meta-top">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<span class="meta-cat">' . esc_html($categories[0]->name) . '</span>';
                            }
                            ?>
                            <span class="meta-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                        </div>
                        
                        <h1 class="single-title"><?php the_title(); ?></h1>
                        
                        <div class="single-author">
                            Por <strong><?php the_author(); ?></strong>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="single-header no-bg">
                    <div class="single-meta-top dark-mode">
                         <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<span class="meta-cat">' . esc_html($categories[0]->name) . '</span>';
                            }
                        ?>
                        <span class="meta-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                    </div>

                    <h1 class="single-title title-dark"><?php the_title(); ?></h1>
                    
                    <div class="single-author title-dark">
                        Por <strong><?php the_author(); ?></strong>
                    </div>
                    <div class="title-divider"></div>
                </div>
            <?php endif; ?>

            <div class="single-content-container">
                <div class="single-body">
                    <?php the_content(); ?>
                </div>

                <footer class="single-footer">
                    
                    <?php 
                    $tags = get_the_tags();
                    if ($tags) : ?>
                        <div class="single-tags">
                            <span>Etiquetas:</span>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">#<?php echo esc_html($tag->name); ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-navigation">
                        <div class="nav-previous"><?php previous_post_link('%link', '<i class="fa-solid fa-arrow-left"></i> Anterior'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'Siguiente <i class="fa-solid fa-arrow-right"></i>'); ?></div>
                    </div>

                </footer>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>