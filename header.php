<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="main-header">

        <div class="header-left">
            <?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
            ?>
        </div>

        <div class="header-center">
            <form role="search" method="get" class="header-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-field" placeholder="¿Qué estás buscando?"
                    value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="search-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <div class="header-right">
            <div class="contact">
                <?php
                $items = json_decode(get_theme_mod('_theme_social_repeater'), true);

                if (!empty($items)):
                    foreach ($items as $item):
                        $icon = esc_attr($item['icon']);
                        $url = esc_url($item['url']);
                        echo "<a href='$url' target='_blank'><i class='$icon'></i></a>";
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <div class="hamburger" id="hamburgerBtn">
            <i class="fa-solid fa-bars"></i>
        </div>

        <nav class="mobile-menu" id="mobileMenu">
            <?php
            if (has_nav_menu('main_menu')) {
                wp_nav_menu([
                    "theme_location" => "main_menu",
                    "container" => "",
                    "items_wrap" => '<ul>%3$s</ul>'
                ]);
            }
            ?>
        </nav>

    </header>

    <nav class="navbar">
        <?php
        if (has_nav_menu('main_menu')) {
            wp_nav_menu([
                "theme_location" => "main_menu",
                "container" => "",
                "items_wrap" => '<ul>%3$s</ul>'
            ]);
        }
        ?>
    </nav>