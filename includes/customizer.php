<?php

// =======================================
// CLASE REPETIDOR: PERSONALIZADA Y DINÁMICA
// =======================================
if (class_exists('WP_Customize_Control')) {

    class _Theme_Repeater_Control extends WP_Customize_Control
    {
        public $type = '_theme_repeater';
        public $repeater_icons = [];
        public $button_text = 'Añadir elemento';

        public function __construct($manager, $id, $args = array())
        {
            parent::__construct($manager, $id, $args);

            if (isset($args['repeater_icons']) && is_array($args['repeater_icons'])) {
                $this->repeater_icons = $args['repeater_icons'];
            }

            if (isset($args['button_text'])) {
                $this->button_text = $args['button_text'];
            }
        }

        public function enqueue()
        {
            // Estandarizado: 'jquery-ui-sortable' es correcto.
            wp_enqueue_script('jquery-ui-sortable');
            
            // EL SCRIPT DE REPETIDOR SE ENCOLA AQUÍ
            wp_enqueue_script('_theme-repeater', get_template_directory_uri() . '/repeater.js', ['jquery', 'jquery-ui-sortable'], false, true);
            
            // Estandarizado: Cambiado el handle del estilo.
            wp_enqueue_style('_theme-repeater-css', get_template_directory_uri() . '/repeater.css');
        }
        
        public function render_content()
        {
            // ... (Contenido del render_content sin cambios) ...
            $value = $this->value();
            $value = $value ? json_decode($value, true) : [];
            $icons = $this->repeater_icons;

            if (empty($icons)) {
                $icons = [];
            }
            ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            </label>

            <div class="_theme-repeater-wrapper <?php echo esc_attr($this->id); ?>">
                <button type="button" class="button add-repeater-item"><?php echo esc_html($this->button_text); ?></button>

                <ul class="_theme-repeater-list">
                    <?php if (!empty($value)): ?>
                        <?php foreach ($value as $item): ?>
                            <li class="_theme-repeater-item">

                                <input type="text" class="title-field" placeholder="Título del sitio"
                                    value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">

                                <select class="icon-select">
                                    <option value="">Elegir icono…</option>
                                    <?php foreach ($icons as $class => $label): ?>
                                        <option value="<?php echo esc_attr($class); ?>" <?php selected(isset($item['icon']) ? $item['icon'] : '', $class); ?>>
                                            <?php echo esc_html($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input type="text" class="icon-field" placeholder="o escribe icono (fa-solid fa-user)"
                                    value="<?php echo esc_attr(isset($item['icon']) ? $item['icon'] : ''); ?>">

                                <input type="text" class="url-field" placeholder="URL" value="<?php echo esc_attr(isset($item['url']) ? $item['url'] : ''); ?>">

                                <span class="drag-handle">☰</span>
                                <button type="button" class="button remove-social">Eliminar</button>
                            </li>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <input type="hidden" class="_theme-repeater-hidden" <?php $this->link(); ?>
                    value="<?php echo esc_attr($this->value()); ?>">

            </div>

            <?php
        }
    }
}


// =======================================
// CLASE PARA DROPDOWN DE CATEGORÍAS
// =======================================
if (class_exists('WP_Customize_Control')) {
    class _Theme_Category_Control extends WP_Customize_Control
    {
        public $type = 'dropdown-categories';

        public function render_content()
        {
            $dropdown = wp_dropdown_categories([
                'show_option_none' => __('— Selecciona una categoría —'),
                'orderby' => 'name',
                'hide_empty' => false,
                'name' => '_customize-dropdown-categories-' . $this->id,
                'selected' => $this->value(),
                'echo' => false
            ]);

            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);

            echo '<label><span class="customize-control-title">' . esc_html($this->label) . '</span></label>';
            echo $dropdown;
        }
    }
}


// ===================================
// REGISTRO DE SECCIONES, AJUSTES Y CONTROLES
// ===================================

// Se mantiene la lógica de registro, pero quitamos el wp_localize_script de aquí.
function _theme_customize_register($wp_customize)
{
    // 1. DEFINICIÓN DE LISTAS DE ICONOS (Se definen aquí para reusarlos en la localización más abajo)
    $social_icons = [
        'fab fa-facebook-f' => 'Facebook',
        'fab fa-instagram' => 'Instagram',
        'fab fa-whatsapp' => 'WhatsApp',
        'fab fa-tiktok' => 'TikTok',
        'fas fa-envelope' => 'Email',
        'fas fa-location-dot' => 'Ubicación',
        'fab fa-x-twitter' => 'Twitter (X)',
        'fab fa-youtube' => 'YouTube',
    ];

    $related_icons = [
        'fa-solid fa-newspaper' => 'Noticia',
        'fa-solid fa-building' => 'Empresa',
        'fa-solid fa-globe' => 'Globo',
    ];
    
    // 2. SECCIÓN REDES SOCIALES
    $wp_customize->add_section('_theme_social_section', [
        'title' => __('Redes Sociales', '_theme'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('_theme_social_repeater', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control(new _Theme_Repeater_Control($wp_customize, '_theme_social_repeater', [
        'label' => __('Redes sociales dinámicas', '_theme'),
        'section' => '_theme_social_section',
        'repeater_icons' => $social_icons,
        'button_text' => 'Añadir red social',
    ]));

    // 3. SECCIÓN SITIOS RELACIONADOS
    $wp_customize->add_section('_theme_related_sites_section', [
        'title' => __('Sitios Relacionados', '_theme'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('_theme_related_sites_repeater', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control(new _Theme_Repeater_Control($wp_customize, '_theme_related_sites_repeater', [
        'label' => __('Sitios relacionados del footer', '_theme'),
        'section' => '_theme_related_sites_section',
        'repeater_icons' => $related_icons,
        'button_text' => 'Añadir sitio relacionado',
    ]));


    // 4. SECCIÓN CONFIGURACIÓN GENERAL
    $wp_customize->add_section('_theme_general_section', array(
        'title' => __('Configuración General', '_theme'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('_theme_posts_per_page', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('_theme_posts_per_page_control', array(
        'label' => __('Cantidad de artículos (Index/Carrusel)', '_theme'),
        'section' => '_theme_general_section',
        'settings' => '_theme_posts_per_page',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 50,
            'step' => 1
        )
    ));
    
    // GUARDAMOS LOS DATOS EN UNA VARIABLE GLOBAL (o en el objeto $wp_customize) 
    // para poder usarlos en el hook de encolado.
    $wp_customize->social_icons = $social_icons;
    $wp_customize->related_icons = $related_icons;
    
}
add_action('customize_register', '_theme_customize_register');


// ===================================
// LOCALIZACIÓN DE SCRIPTS (CORRECTA UBICACIÓN)
// ===================================
function _theme_customize_scripts_localize() {
    global $wp_customize;
    
    // Obtenemos los datos que guardamos en el hook anterior.
    $social_icons = isset($wp_customize->social_icons) ? $wp_customize->social_icons : [];
    $related_icons = isset($wp_customize->related_icons) ? $wp_customize->related_icons : [];

    // Ahora el script _theme-repeater ya ha sido encolado por la clase de control.
    wp_localize_script('_theme-repeater', 'ThemeRepeaterData', [
        'social_icons' => $social_icons,
        'related_icons' => $related_icons,
        'social_id' => '_theme_social_repeater', 
        'related_id' => '_theme_related_sites_repeater' 
    ]);
}
add_action('customize_controls_enqueue_scripts', '_theme_customize_scripts_localize');