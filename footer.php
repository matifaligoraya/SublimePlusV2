<?php
/**
 * Default site footer
 *
 * @package SublimePulse\Templates
 * @author   SublimePulse
 * @link     https://www.SublimePulse.com/
 *
 */

?>

<a href="#" class="link-top" id="link-top"><span><i class="fas fa-chevron-up"></i></span></a>

<div class="overlay"></div>

<div class="loader">
    <div class="loader-inner line-spin-fade-loader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<?php $settings = get_option(Sublimeplus_SETTINGS_KEY);
if (isset($settings['html_of_login_popup_in_menu'])) {
    echo $settings['html_of_login_popup_in_menu'];
}
?>

<?php 
                    //    print_r($settings);
                        if (isset($settings['html_of_login_popup_in_menu']) && $settings['html_of_login_popup_in_menu'] == 1) {
                          ?>
                            
                           <?php 
                           echo wp_kses_post($settings['html_of_login_popup_in_menu']);
                           ?>
                          <?php
                        }?>
</body>

</html>
<!-- <div class="sublimeplus-mask-close"></div>
<footer id="site-footer" class="site-footer">
    <div class="container">
        <?php
        echo esc_html(get_theme_mod('Sublimeplus_footer_copy_right',sprintf(esc_html__( '© %s SublimePulse. All rights reserved.', 'sublimeplus' ),date("Y"))));
        ?>
    </div>
</footer> -->
<?php
wp_footer();
?>
</body>
</html>
