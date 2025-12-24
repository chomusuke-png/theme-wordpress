<footer class="footer">
    <div class="footer-container">

        <?php if (is_active_sidebar('footer-widget-main')): ?>
            <div class="footer-widgets">
                <?php dynamic_sidebar('footer-widget-main'); ?>
            </div>
        <?php endif; ?>

        <div class="footer-links">
            <h3>Nuestros Sitios Relacionados</h3>
            <ul>
                <?php
                $related = json_decode(get_theme_mod('_theme_related_sites_repeater'), true);

                if (!empty($related)):
                    foreach ($related as $site):
                        $title = esc_html($site['title']);
                        $url = esc_url($site['url']);
                        $icon = esc_attr($site['icon']);
                        echo "
                        <li>
                            <a href='$url' target='_blank' rel='noopener'>
                                <i class='$icon'></i> $title
                            </a>
                        </li>
                    ";
                    endforeach;
                endif;
                ?>
            </ul>
        </div>

        <div class="footer-copy">
            © <?php echo date("Y"); ?> <?php bloginfo('name'); ?> – Todos los derechos reservados.
        </div>
    </div>
</footer>

<button id="btnTop"><i class="fas fa-arrow-up"></i></button>

<?php wp_footer(); ?>
</body>

</html>