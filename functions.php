<?php
/**
 * Configuración principal del tema y registro de componentes.
 */
function theme_setup()
{
    add_theme_support('custom-logo');
    add_theme_support('title-tag');

    register_nav_menus(array(
        'main_menu' => esc_html__('Menu', 'textdomain'),
    ));

    // 1. Widgets Home Estándar (Cajas con estilo)
    register_sidebar(array(
        'name'          => esc_html__('Home Widgets (Estándar)', 'textdomain'),
        'id'            => 'home-widgets',
        'description'   => esc_html__('Widgets con fondo blanco, sombra y padding (Texto, Listas).', 'textdomain'),
        'before_widget' => '<div id="%1$s" class="home-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="home-widget-title">',
        'after_title'   => '</h3>',
    ));

    // 2. Widgets Home "Raw" (Sin estilos/padding)
    register_sidebar(array(
        'name'          => esc_html__('Home Widgets (Sin Estilos/Full)', 'textdomain'),
        'id'            => 'home-widgets-raw',
        'description'   => esc_html__('Área libre sin padding ni bordes. Ideal para scripts, iframes o diseños a medida.', 'textdomain'),
        'before_widget' => '<div id="%1$s" class="home-widget-raw %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="home-widget-title">',
        'after_title'   => '</h3>',
    ));

    // 3. Footer Widget
    register_sidebar(array(
        'name' => esc_html__("Footer Widget Principal", 'textdomain'),
        'id' => "footer-widget-main",
        'description' => esc_html__("Área única del footer centrada.", 'textdomain'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    // 4. Navbar Widget
    register_sidebar(array(
        'name'          => esc_html__('Navbar Widget (Menu Item)', 'textdomain'),
        'id'            => 'navbar-widget',
        'description'   => esc_html__('Se mostrará al final del menú principal. Ideal para selectores de idioma.', 'textdomain'),
        'before_widget' => '<li id="%1$s" class="menu-item navbar-widget-item %2$s">', // Importante: es un <li>
        'after_widget'  => '</li>',
        'before_title'  => '<span class="hidden-title" style="display:none;">',
        'after_title'   => '</span>',
    ));
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Carga de scripts y estilos del tema.
 */
function theme_enqueue_assets()
{
    // 1. Librerías Externas
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    // 2. BASE (Globales)
    wp_enqueue_style(
        'theme-base',
        get_template_directory_uri() . '/assets/css/base/globals.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/base/globals.css')
    );

    // 3. LAYOUT (Estructura)
    wp_enqueue_style(
        'theme-header',
        get_template_directory_uri() . '/assets/css/layout/header.css',
        array('theme-base'),
        filemtime(get_template_directory() . '/assets/css/layout/header.css')
    );
    wp_enqueue_style(
        'theme-navbar',
        get_template_directory_uri() . '/assets/css/layout/navbar.css',
        array('theme-header'),
        filemtime(get_template_directory() . '/assets/css/layout/navbar.css')
    );
    wp_enqueue_style(
        'theme-footer',
        get_template_directory_uri() . '/assets/css/layout/footer.css',
        array('theme-base'),
        filemtime(get_template_directory() . '/assets/css/layout/footer.css')
    );

    // 4. MODULES (Componentes)
    wp_enqueue_style(
        'theme-hero-slider',
        get_template_directory_uri() . '/assets/css/modules/hero-slider.css',
        array('swiper-css', 'theme-base'),
        filemtime(get_template_directory() . '/assets/css/modules/hero-slider.css')
    );
    wp_enqueue_style(
        'theme-categories',
        get_template_directory_uri() . '/assets/css/modules/categories.css',
        array('theme-base'),
        filemtime(get_template_directory() . '/assets/css/modules/categories.css')
    );
    wp_enqueue_style(
        'theme-chips',
        get_template_directory_uri() . '/assets/css/modules/chips.css',
        array('theme-base'),
        filemtime(get_template_directory() . '/assets/css/modules/chips.css')
    );
    wp_enqueue_style(
        'theme-btn-top',
        get_template_directory_uri() . '/assets/css/modules/button-top.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/modules/button-top.css')
    );

    // 5. PAGES (Vistas específicas)
    if (is_singular('post')) {
        wp_enqueue_style(
            'theme-single',
            get_template_directory_uri() . '/assets/css/pages/single.css',
            array('theme-base'),
            filemtime(get_template_directory() . '/assets/css/pages/single.css')
        );
    }

    if (is_page()) {
        wp_enqueue_style(
            'theme-page',
            get_template_directory_uri() . '/assets/css/pages/page.css',
            array('theme-base'),
            filemtime(get_template_directory() . '/assets/css/pages/page.css')
        );
    }

    if (is_archive() || is_search() || is_home()) {
        // Nota: is_home() a veces usa estilos de archive para las tarjetas
        wp_enqueue_style(
            'theme-archive',
            get_template_directory_uri() . '/assets/css/pages/archive.css',
            array('theme-base'),
            filemtime(get_template_directory() . '/assets/css/pages/archive.css')
        );
    }

    // SCRIPTS JS
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

/**
 * Filtra la consulta de búsqueda para incluir solo posts y páginas.
 *
 * @param WP_Query $query La consulta principal de WordPress.
 * @return WP_Query La consulta modificada.
 */
function filter_search_query($query) {
    if ($query->is_search && !is_admin()) {
        $query->set('post_type', array('post', 'page'));
    }
    return $query;
}
add_filter('pre_get_posts', 'filter_search_query');
?>