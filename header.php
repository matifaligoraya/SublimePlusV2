<?php
/**
 * The template for displaying the header
 *
 * @package SublimePulse\Templates
 * @author   SublimePulse
 * @link     https://www.SublimePulse.com/
 *
 */
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>
<?php
wp_body_open();
//$theme_settings = get_option(SUBLIMEPLUS_SETTINGS_KEY);
$settings = get_option(Sublimeplus_SETTINGS_KEY);
//print_r($settings);
?>

<header class="header">
    <div class="header-top">
<!--        <div class="link">-->
<!--            <a href="#">On-demand Analysis</a>-->
<!--            <span class="new">new</span>-->
<!--        </div>-->
<!--        <div class="sep"></div>-->
        <div class="header-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
    <div class="header-bottom">
       
        <?php get_template_part('inc/templates/logo'); ?>
      
        <div class="header-inner">
       
                    <nav id="primary-menu" class="primary-menu header-nav">
                        <span class="button-close-nav close-nav">
                            <i class="sublimeplus-icon-close"></i>
                        </span>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary-menu',
                            'container' => false,
                            'container_id' => false,
                            'container_class' => false,
                            'menu_id' => false,
                            'menu_class' => '',
                        //    'walker' => Sublimeplus_get_walker_nav_menu(),
                            'fallback_cb' => false,
                        ));
                        ?>
                    </nav>
                    <div class="header-buttons d-none d-sm-flex">
                        <?php 
                       // print_r($settings);
                        if (isset($settings['enable_login_popup_in_menu']) && $settings['enable_login_popup_in_menu'] == 1) {
                          ?>
                            <a href="#" class="link" data-toggle="modal" data-target="#modalLogin">Login</a>
                            
                          <?php
                        }?>
          
       
                <?php  if (isset($settings['show_trial_button_in_menu']) && $settings['show_trial_button_in_menu']== 1) {?>
                <a href="<?php echo $settings['trial_button_url']!= "" ? $settings['trial_button_url'] : "#"?>" class="btn btn--sm btn--secondary">
                    <?php echo $settings['trial_button_text']!= "" ? $settings['trial_button_text'] : "Start 14-Day Trial"?>
                </a>
                <?php
                        }?>
                </div>
           </div>
        <button class="open-nav-btn c-hamburger c-hamburger--htx">
            <span>toggle menu</span>
        </button>
    </div>
</header>
