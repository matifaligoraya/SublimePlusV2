<?php
/**
 * Css class wrap main content
 * @uses: call function Sublimeplus_main_content_css
 * @return $main_class css class wrap main content
 * */
if (!function_exists('Sublimeplus_main_content_css')) {
    function Sublimeplus_main_content_css()
    {
        $main_class = 'main-content';
        if (!is_single()) {
            $sidebar = get_theme_mod('Sublimeplus_blog_sidebar_config', 'right');
            if (is_active_sidebar(get_theme_mod('Sublimeplus_blog_sidebar', 'sidebar')) && $sidebar != '') {
                $main_class .= ' has-' . $sidebar . '-sidebar has-sidebar';
            } else {
                $main_class .= ' without-sidebar';
            }
        } else {
            $sidebar = Sublimeplus_single_post_sidebar();
            if ($sidebar != '' && is_active_sidebar(get_theme_mod('Sublimeplus_blog_single_sidebar', 'sidebar'))) {
                $main_class .= ' has-' . $sidebar . '-sidebar has-sidebar';
            } else {
                $main_class .= ' without-sidebar';
            }
        }
        return apply_filters('Sublimeplus_main_content_css', $main_class);
    }
}
/**
 * Css class wrap loop content
 * @uses: call function Sublimeplus_loop_content_css
 * @return $loop_class css class wrap main content
 * */
if (!function_exists('Sublimeplus_loop_content_css')) {
    function Sublimeplus_loop_content_css()
    {
        $Sublimeplus_block_layout = get_theme_mod('Sublimeplus_blog_layout', 'list');
        $loop_class = 'wrap-loop-content col-12';
        $Sublimeplus_sidebar = get_theme_mod('Sublimeplus_blog_sidebar_config', 'right');
        if(is_author() && get_the_author_meta('description')!=''){
            $loop_class .= ' col-md-9';
        }else if(is_active_sidebar(get_theme_mod('Sublimeplus_blog_sidebar', 'sidebar')) && $Sublimeplus_sidebar != '') {
            $loop_class .= ' col-md-9';
        }
        if($Sublimeplus_block_layout=='masonry'){
            $loop_class .=' grid-layout';
            wp_enqueue_script('isotope');
        }
        $loop_class .= ' ' . $Sublimeplus_block_layout . '-layout';
        return apply_filters('Sublimeplus_loop_content_css', $loop_class);
    }
}
/**
 * Css class wrap loop content
 * @uses: call function Sublimeplus_single_content_css
 * @return $wrap_class css class wrap main single content
 * */
if (!function_exists('Sublimeplus_single_content_css')) {
    function Sublimeplus_single_content_css()
    {
        $sidebar = Sublimeplus_single_post_sidebar();
        $wrap_class = 'col-12 wrap-post-content-without-sidebar';
        if ($sidebar != '' && is_active_sidebar(get_theme_mod('Sublimeplus_blog_single_sidebar', 'sidebar'))) {
            $wrap_class = 'col-12 col-md-8 wrap-post-content-has-sidebar';
        }
        $header_align=get_post_meta(get_the_ID(),'Sublimeplus_blog_single_header_align',true);
        if($header_align=='inherit'||$header_align==''){
            $header_align=get_theme_mod('Sublimeplus_blog_single_post_header_align','center');
        }
        $wrap_class .=' header-post-align-'.$header_align;
        return apply_filters('Sublimeplus_single_content_css', $wrap_class);
    }
}
/**
 * Css class wrap post loop item
 * @uses: call function Sublimeplus_post_loop_css
 * @return $loop_class css class wrap main content
 * */
if (!function_exists('Sublimeplus_post_loop_item_css')) {
    function Sublimeplus_post_loop_item_css()
    {
        if (get_theme_mod('Sublimeplus_blog_layout', 'list') == 'list') {
            $class = 'post-loop-item list-layout-item col-12';
        }elseif (get_theme_mod('Sublimeplus_blog_layout' ) == 'list-2') {
            $class = 'post-loop-item list-layout-item list-2 col-12';
        } else {
            $class = 'post-loop-item grid-layout-item ';
            switch (get_theme_mod('Sublimeplus_blog_cols', '3')) {
                case '2':
                    $class .= "col-12 col-sm-6";
                    break;
                case '3':
                    $class .= "col-12 col-sm-4";
                    break;
                case '4':
                    $class .= "col-12 col-sm-6 col-md-3";
                    break;
                case '5':
                    $class .= "col-12 col-md-1-5";
                    break;
                case '6':
                    $class .= "col-12 col-sm-4 col-md-2";
                    break;
                default:
                    $class .= "col-12";
                    break;
            }
        }
        if(!has_post_thumbnail()){
            $class.=' without-thumbnail';
        }
        return apply_filters('Sublimeplus_post_loop_item_css', $class);
    }
}
/**
 * Password form template for detail post
 * @uses: hook to the_password_form
 * @return html of password form
 * */
if (!function_exists('Sublimeplus_password_form')) {
    function Sublimeplus_password_form()
    {
        global $post;
        $Sublimeplus_id = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
        $Sublimeplus_form = '<div class="sublimeplus-form-login"><form action="' . esc_url(home_url('wp-login.php?action=postpass', 'login_post')) . '" method="post"><h4>
    ' . esc_html__('To view this protected post, enter the password below:', 'sublimeplus') . '</h4>
    <input name="post_password" id="' . $Sublimeplus_id . '" type="password" size="20" maxlength="20" placeholder="' . esc_attr__('Enter Password', 'sublimeplus') . ' " /><br><input type="submit" name="Submit" value="' . esc_attr__('Submit', 'sublimeplus') . '" />
    </form></div>
    ';
        return $Sublimeplus_form;
    }
}
add_filter('the_password_form', 'Sublimeplus_password_form');

/**
 * Site layout
 * @uses: call function Sublimeplus_site_layout()
 * @return site layout
 * */
if (!function_exists('Sublimeplus_site_layout')) {
    function Sublimeplus_site_layout()
    {
        $Sublimeplus_site_layout = get_theme_mod('Sublimeplus_site_layout', 'normal');
        if (is_page() && get_post_meta(get_the_ID(), 'Sublimeplus_site_layout', true) != '' && get_post_meta(get_the_ID(), 'Sublimeplus_site_layout', true) != 'inherit') {
            $Sublimeplus_site_layout = get_post_meta(get_the_ID(), 'Sublimeplus_site_layout', true);
        }
        if (isset($_GET['Sublimeplus_site_layout'])) {
            $Sublimeplus_site_layout = $_GET['Sublimeplus_site_layout'];
        }
        return $Sublimeplus_site_layout;
    }
}
/**
 * Site full width
 * @uses: call function Sublimeplus_site_width()
 * @return css for site full width
 * */
if (!function_exists('Sublimeplus_site_width')) {
    function Sublimeplus_site_width()
    {
        $Sublimeplus_site_width = '';
        if (Sublimeplus_site_layout() != 'full-width') {
            $Sublimeplus_site_width = get_theme_mod('Sublimeplus_site_max_width', '1170');
            if (is_page() && get_post_meta(get_the_ID(), 'Sublimeplus_site_max_width', true) != '') {
                $Sublimeplus_site_width = get_post_meta(get_the_ID(), 'Sublimeplus_site_max_width', true);
            }
            if (isset($_GET['Sublimeplus_site_max_width'])) {
                $Sublimeplus_site_width = $_GET['Sublimeplus_site_max_width'];
            }
        }
        return $Sublimeplus_site_width.'px';
    }
}

/**
 * Resolve sidebar position for pages.
 * Priority: page meta → Customizer → '' (none / full-width).
 */
if (!function_exists('Sublimeplus_page_sidebar')) {
    function Sublimeplus_page_sidebar() {
        $meta = get_post_meta(get_the_ID(), '_sp_page_sidebar', true);
        if ($meta !== '' && $meta !== 'inherit' && $meta !== false) {
            return $meta;
        }
        return get_theme_mod('Sublimeplus_page_sidebar_config', '');
    }
}

/**
 * Check single post sidebar
 * @uses: call function Sublimeplus_single_post_sidebar()
 * @return sidebar option
 * */
if (!function_exists('Sublimeplus_single_post_sidebar')) {
    function Sublimeplus_single_post_sidebar()
    {
        $sidebar = get_post_meta(get_the_id(), 'Sublimeplus_blog_single_sidebar_config', true);
        if ($sidebar != 'inherit' && $sidebar) {
            return $sidebar;
        } else {
            return get_theme_mod('Sublimeplus_blog_single_sidebar_config', '');
        }
    }
}
/**
 * Check GDPG plugin is installed
 * @uses: call function Sublimeplus_gdpr_consent()
 * @return boolean
 * */
if (!function_exists('Sublimeplus_gdpr_consent')) {
    function Sublimeplus_gdpr_consent()
    {
        if (class_exists('GDPR')) {
            return GDPR::get_consent_checkboxes();
        } else {
            return false;
        }
    }
}
/**
 * Get Preset Color
 * @uses: call function sublimeplus_preset()
 * @return color
 * */
if (!function_exists('sublimeplus_preset')) {
    function sublimeplus_preset()
    {
        $preset = get_theme_mod('Sublimeplus_color_preset', 'default');
        if (isset($_GET['preset'])) {
            $preset = $_GET['preset'];
        }
        switch ($preset) {
            case 'custom':
                $preset = get_theme_mod('Sublimeplus_primary_color', '');
                break;
            case 'black':
                $preset = '#000';
                break;
            case 'blue':
                $preset = '#0366d6';
                break;
            case 'red':
                $preset = '#fc2929';
                break;
            case 'yellow':
                $preset = '#FFFF00';
                break;
            case 'green':
                $preset = '#269f42';
                break;
            case 'grey':
                $preset = '#778899';
                break;
            default:
                $preset = '';
                break;
        }
        return $preset;
    }
}
/**
 * Get list image sizes
 * @return array image size
 */
if (!function_exists('Sublimeplus_get_image_sizes')) {
    function Sublimeplus_get_image_sizes()
    {
        global $_wp_additional_image_sizes;
        $output = array();
        $imgs_size = get_intermediate_image_sizes();
        foreach ($imgs_size as $size) :
            if (in_array($size, array('thumbnail', 'medium', 'medium_large', 'large'))) :
                $output[$size] = ucwords(str_replace(array('_', ' - '), array(
                        ' ',
                        ' '
                    ), $size)) . ' (' . get_option("{$size}_size_w") . 'x' . get_option("{$size}_size_h") . ')';
            elseif (isset($_wp_additional_image_sizes[$size])) :
                $output[$size] = ucwords(str_replace(array('_', '-'), array(
                        ' ',
                        ' '
                    ), $size)) . ' (' . $_wp_additional_image_sizes[$size]['width'] . 'x' . $_wp_additional_image_sizes[$size]['height'] . ')';
            endif;
        endforeach;
        $output['full'] = esc_html__('Full', 'sublimeplus');

        return $output;
    }
}
/**
 * Get all pages
 * @return array pages
 * */
if (!function_exists('Sublimeplus_get_pages')) {
    function Sublimeplus_get_pages()
    {
        $pages = array();
        $all_pages = get_posts(array(
                'posts_per_page' => -1,
                'post_type' => 'page',
            )
        );
        $pages[''] = esc_html__('None', 'sublimeplus');
        if (!empty($all_pages) && !is_wp_error($all_pages)) {
            foreach ($all_pages as $page) {
                $pages[$page->ID] = $page->post_title;
            }
        }
        return $pages;
    }
}