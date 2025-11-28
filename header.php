<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="main-header">

        <!-- LOGO -->
        <div class="header-left">
            <?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
            ?>
        </div>

        <!-- TEXTO PRINCIPAL -->
        <div class="header-center">
            <p class="header-slogan"><?php bloginfo('description'); ?></p>
        </div>

        <!-- BOTONES → redes -->
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


        <!-- Botón móvil -->
        <div class="hamburger" id="hamburgerBtn">
            <i class="fa-solid fa-bars"></i>
        </div>

    </header>

    <!-- NAV -->
    <nav class="navbar">
        <?php
        wp_nav_menu([
            "theme_location" => "main_menu",
            "container" => "",
            "items_wrap" => '<ul>%3$s</ul>'
        ]);
        ?>
    </nav>

    <!-- NAV MÓVIL -->
    <nav class="mobile-menu" id="mobileMenu">
        <?php
        wp_nav_menu([
            "theme_location" => "main_menu",
            "container" => "",
            "items_wrap" => '<ul>%3$s</ul>'
        ]);
        ?>
    </nav>