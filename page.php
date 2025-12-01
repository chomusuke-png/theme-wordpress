<?php get_header(); ?>

<main class="page-main-wrapper">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>

            <?php if (has_post_thumbnail()) : ?>
                <div class="page-header has-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>');">
                    <div class="page-header-overlay"></div>
                    <div class="page-header-content">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            <?php else : ?>
                <div class="page-header no-bg">
                    <h1 class="page-title title-dark"><?php the_title(); ?></h1>
                    <div class="title-divider"></div>
                </div>
            <?php endif; ?>

            <div class="page-content-container">
                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>