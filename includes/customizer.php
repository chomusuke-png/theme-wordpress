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
        public $mode = 'icon'; // 'icon' (default) o 'image'
        
        public $input_labels = [
            'title' => 'Título',
            'icon'  => 'Icono / Imagen',
            'url'   => 'URL'
        ];

        public function __construct($manager, $id, $args = array())
        {
            parent::__construct($manager, $id, $args);

            if (isset($args['repeater_icons']) && is_array($args['repeater_icons'])) {
                $this->repeater_icons = $args['repeater_icons'];
            }

            if (isset($args['button_text'])) {
                $this->button_text = $args['button_text'];
            }

            if (isset($args['mode'])) {
                $this->mode = $args['mode'];
            }

            if (isset($args['input_labels']) && is_array($args['input_labels'])) {
                $this->input_labels = array_merge($this->input_labels, $args['input_labels']);
            }
        }

        public function enqueue()
        {
            // IMPORTANTE: Encolar la librería de medios de WordPress
            wp_enqueue_media();
            
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('_theme-repeater', get_template_directory_uri() . '/repeater.js', ['jquery', 'jquery-ui-sortable'], false, true);
            wp_enqueue_style('_theme-repeater-css', get_template_directory_uri() . '/repeater.css');
        }
        
        public function render_content()
        {
            $value = $this->value();
            $value = $value ? json_decode($value, true) : [];
            $icons = $this->repeater_icons;
            ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            </label>

            <div class="_theme-repeater-wrapper <?php echo esc_attr($this->id); ?>" data-mode="<?php echo esc_attr($this->mode); ?>">
                <button type="button" class="button add-repeater-item"><?php echo esc_html($this->button_text); ?></button>

                <ul class="_theme-repeater-list">
                    <?php if (!empty($value)): ?>
                        <?php foreach ($value as $item): ?>
                            <li class="_theme-repeater-item">
                                <label class="field-label"><?php echo esc_html($this->input_labels['title']); ?></label>
                                <input type="text" class="title-field" placeholder="Ej: Nombre Empresa"
                                    value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">

                                <label class="field-label"><?php echo esc_html($this->input_labels['icon']); ?></label>
                                
                                <?php if ($this->mode === 'image'): ?>
                                    <div class="image-upload-controls">
                                        <?php 
                                            $img_val = isset($item['icon']) ? $item['icon'] : ''; 
                                            $display_style = $img_val ? 'display:block;' : 'display:none;';
                                        ?>
                                        <img src="<?php echo esc_url($img_val); ?>" class="repeater-image-preview" style="<?php echo $display_style; ?>" />
                                        
                                        <input type="hidden" class="icon-field" value="<?php echo esc_attr($img_val); ?>">
                                        <button type="button" class="button upload-repeater-image">Seleccionar Imagen</button>
                                        <?php if($img_val): ?>
                                            <button type="button" class="button remove-repeater-image" style="color: #a00;">X</button>
                                        <?php endif; ?>
                                    </div>

                                <?php else: ?>
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
                                <?php endif; ?>

                                <label class="field-label"><?php echo esc_html($this->input_labels['url']); ?></label>
                                <input type="text" class="url-field" placeholder="https://..." value="<?php echo esc_attr(isset($item['url']) ? $item['url'] : ''); ?>">

                                <span class="drag-handle">☰</span>
                                <button type="button" class="button remove-social">Eliminar ítem</button>
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

// ===================================
// REGISTRO DE SECCIONES Y AJUSTES
// ===================================

function _theme_customize_register($wp_customize)
{
    // ICONOS PREDEFINIDOS
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
    
    // 1. REDES SOCIALES
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
        'mode' => 'icon', // Modo normal
        'input_labels' => ['title' => 'Título', 'icon' => 'Clase Icono (fa-...)', 'url' => 'Enlace']
    ]));

    // 2. SITIOS RELACIONADOS
    $wp_customize->add_section('_theme_related_sites_section', [
        'title' => __('Sitios Relacionados (Footer)', '_theme'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('_theme_related_sites_repeater', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control(new _Theme_Repeater_Control($wp_customize, '_theme_related_sites_repeater', [
        'label' => __('Enlaces del Footer', '_theme'),
        'section' => '_theme_related_sites_section',
        'repeater_icons' => $related_icons,
        'button_text' => 'Añadir sitio',
        'mode' => 'icon', // Modo normal
        'input_labels' => ['title' => 'Texto del enlace', 'icon' => 'Clase Icono', 'url' => 'URL Destino']
    ]));

    // 3. ALIADOS / PARTNERS (MODO IMAGEN)
    $wp_customize->add_section('_theme_partners_section', [
        'title' => __('Aliados y Logos', '_theme'),
        'priority' => 32,
    ]);

    $wp_customize->add_setting('_theme_partners_repeater', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control(new _Theme_Repeater_Control($wp_customize, '_theme_partners_repeater', [
        'label' => __('Logos del Slider', '_theme'),
        'section' => '_theme_partners_section',
        'button_text' => 'Añadir Aliado',
        'mode' => 'image', // <--- ESTO ACTIVA EL SUBIDOR DE IMÁGENES
        'input_labels' => [
            'title' => 'Nombre de la empresa',
            'icon'  => 'Logo de la empresa',
            'url'   => 'Sitio web (Opcional)'
        ]
    ]));

    // 4. MARCAS QUE CONFÍAN (GRID) - NUEVO
    $wp_customize->add_section('_theme_brands_section', [
        'title' => __('Marcas (Grilla)', '_theme'),
        'priority' => 33,
        'description' => 'Logos que se mostrarán en formato grilla (más pequeños).'
    ]);

    $wp_customize->add_setting('_theme_brands_repeater', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control(new _Theme_Repeater_Control($wp_customize, '_theme_brands_repeater', [
        'label' => __('Logos de Marcas', '_theme'),
        'section' => '_theme_brands_section',
        'button_text' => 'Añadir Marca',
        'mode' => 'image', // Usamos el modo imagen también
        'input_labels' => [
            'title' => 'Nombre de la marca',
            'icon'  => 'Logo',
            'url'   => 'Sitio web (Opcional)'
        ]
    ]));

    // 5. GENERAL
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
        'label' => __('Cantidad de artículos', '_theme'),
        'section' => '_theme_general_section',
        'settings' => '_theme_posts_per_page',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1)
    ));
    
    $wp_customize->social_icons = $social_icons;
    $wp_customize->related_icons = $related_icons;
}
add_action('customize_register', '_theme_customize_register');

function _theme_customize_scripts_localize() {
    global $wp_customize;
    $social_icons = isset($wp_customize->social_icons) ? $wp_customize->social_icons : [];
    $related_icons = isset($wp_customize->related_icons) ? $wp_customize->related_icons : [];

    wp_localize_script('_theme-repeater', 'ThemeRepeaterData', [
        'social_icons' => $social_icons,
        'related_icons' => $related_icons,
        'social_id' => '_theme_social_repeater', 
        'related_id' => '_theme_related_sites_repeater' 
    ]);
}
add_action('customize_controls_enqueue_scripts', '_theme_customize_scripts_localize');