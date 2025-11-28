<footer class="footer">
    <div class="footer-container">

        <!-- FOOTER WIDGETS -->
        <?php if (is_active_sidebar('footer_1') || is_active_sidebar('footer_2') || is_active_sidebar('footer_3')): ?>
            <div class="footer-widgets">
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer_1')): ?>
                        <?php dynamic_sidebar('footer_1'); ?>
                    <?php endif; ?>
                </div>

                <div class="footer-column">
                    <?php if (is_active_sidebar('footer_2')): ?>
                        <?php dynamic_sidebar('footer_2'); ?>
                    <?php endif; ?>
                </div>

                <div class="footer-column">
                    <?php if (is_active_sidebar('footer_3')): ?>
                        <?php dynamic_sidebar('footer_3'); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- SITIOS RELACIONADOS -->
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

        <!-- COPYRIGHT -->
        <div class="footer-copy">
            © <?php echo date("Y"); ?> <?php bloginfo('name'); ?> – Todos los derechos reservados.
        </div>
    </div>
</footer>

<button id="btnTop"><i class="fas fa-arrow-up"></i></button>

<?php wp_footer(); ?>
</body>

</html>