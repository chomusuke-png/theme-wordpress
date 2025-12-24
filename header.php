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
            
            <?php
            // Obtenemos los valores del customizer
            $btn_text = get_theme_mod('_theme_header_btn_text', 'Hazte Miembro');
            $btn_url  = get_theme_mod('_theme_header_btn_url', home_url('/hazte-miembro'));
            
            if (!empty($btn_text)): 
            ?>
                <a href="<?php echo esc_url($btn_url); ?>" class="btn-member">
                    <?php echo esc_html($btn_text); ?>
                </a>
            <?php endif; ?>

            <div class="social-menu-container">
                <button id="socialToggleBtn" class="btn-social-toggle" aria-label="Síguenos">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span class="btn-text">REDES</span>
                </button>

                <div class="social-dropdown" id="socialDropdown">
                    <?php
                    $items = json_decode(get_theme_mod('_theme_social_repeater'), true);

                    if (!empty($items)):
                        foreach ($items as $item):
                            $icon = esc_attr($item['icon']);
                            $url = esc_url($item['url']);
                            $title = isset($item['title']) ? esc_attr($item['title']) : '';
                            // Solo icono dentro del enlace circular
                            echo "<a href='$url' target='_blank' title='$title' class='social-circle-btn'><i class='$icon'></i></a>";
                        endforeach;
                    endif;
                    ?>
                </div>
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
        $navbar_widgets_html = '';
        if (is_active_sidebar('navbar-widget')) {
            ob_start();
            dynamic_sidebar('navbar-widget');
            $navbar_widgets_html = ob_get_clean();
        }

        if (has_nav_menu('main_menu')) {
            wp_nav_menu([
                "theme_location" => "main_menu",
                "container" => "",
                "items_wrap" => '<ul>%3$s' . $navbar_widgets_html . '</ul>'
            ]);
        }
        ?>
    </nav>