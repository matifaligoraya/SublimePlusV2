<?php
/**
 * Logo template — outputs WordPress custom logo with site title fallback
 *
 * @package SublimePlusV2
 */

if (has_custom_logo()) {
    the_custom_logo();
} elseif (display_header_text()) {
    ?>
    <a class="site-title-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <?php bloginfo('name'); ?>
    </a>
    <?php
    $description = get_bloginfo('description', 'display');
    if ($description || is_customize_preview()) { ?>
        <p class="site-description"><?php echo esc_html($description); ?></p>
    <?php }
}
