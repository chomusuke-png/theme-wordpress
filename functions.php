<?php

function theme_setup()
{
    add_theme_support('custom-logo');

    add_theme_support('title-tag');

    // 1. Registra la ubicación principal del menú
    register_nav_menus(array(
        'main_menu' => esc_html__('Menu', 'textdomain'),
    ));

    // 2. Registra las áreas de widgets del footer de forma simplificada
    $footer_widgets_count = 3;

    for ($i = 1; $i <= $footer_widgets_count; $i++) {
        register_sidebar(array(
            'name' => esc_html__("Footer Widget $i", 'textdomain'),
            'id' => "footer-widget-$i",
            'description' => esc_html__("Área para el widget $i del footer.", 'textdomain'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>',
        ));
    }
}
add_action('after_setup_theme', 'theme_setup');


function theme_enqueue_assets()
{
    // Estilos externos
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );

    // Estilos locales
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri() . '/assets/css/globals.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/globals.css')
    );
    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/assets/css/header.css',
        array('global-style'),
        filemtime(get_template_directory() . '/assets/css/header.css')
    );
    wp_enqueue_style(
        'nav-style',
        get_template_directory_uri() . '/assets/css/navbar.css',
        array('main-style'),
        filemtime(get_template_directory() . '/assets/css/navbar.css')
    );
    wp_enqueue_style(
        'footer-style',
        get_template_directory_uri() . '/assets/css/footer.css',
        array('main-style'),
        filemtime(get_template_directory() . '/assets/css/footer.css')
    );
    wp_enqueue_style(
        'button-top-style',
        get_template_directory_uri() . '/assets/css/button-top.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/button-top.css')
    );
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );
    wp_enqueue_style(
        'hero-slider',
        get_template_directory_uri() . '/assets/css/hero-slider.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/hero-slider.css')
    );
    
    // Scripts
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );
    wp_enqueue_script(
        'main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

require_once get_template_directory() . '/includes/customizer.php';
?>