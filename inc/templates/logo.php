<?php
/** Logo
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2019 SublimePulse
 */

if (get_theme_mod('custom_logo')) { ?>
    


        <a href="<?php echo esc_url(home_url('/')); ?>"
           rel="<?php esc_attr_e('home', 'sublimeplus'); ?>"
           title="<?php bloginfo('name'); ?>" class="header-logo">
            <img src="<?php echo wp_get_attachment_image_url(get_theme_mod('custom_logo'),'full')?>" alt="<?php bloginfo('name'); ?>"/>
        </a>

    <?php
}
if (display_header_text()) {
    ?>
    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                              rel="<?php esc_attr_e('home', 'sublimeplus'); ?>"
                              title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
    <?php
    $Sublimeplus_site_description = get_bloginfo('description', 'display');
    if ($Sublimeplus_site_description || is_customize_preview()) { ?>
        <p class="site-description"><?php echo esc_html($Sublimeplus_site_description); ?></p>
    <?php }
}
