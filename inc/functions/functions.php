<?php
/**
 * Theme functions
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 
 * @des         All custom functions of theme can add here. Dev can add or remove function.
 */

/**
 * Add Mask background to cafe footer builder
*/
if(!function_exists('Sublimeplus_bottom_footer')) {
    function Sublimeplus_bottom_footer()
    {
        $allowhtml = array('div' => array('class' =>array()));
        echo wp_kses('<div class="sublimeplus-mask-close"></div>', $allowhtml);
        if(get_theme_mod('Sublimeplus_enable_back_top_top','1')){
            ?>
            <a id="sublimeplus-back-to-top" href="#cafe-site-header" title="<?php echo esc_attr__('Back to Top','sublimeplus')?>"><i class="cs-font clever-icon-up"></i></a>
            <?php
        }
    }
}
add_action('cafe_after_footer','Sublimeplus_bottom_footer',10);
/**
 * Edit the except length characters.
 *
 */
if (!function_exists('Sublimeplus_custom_excerpt_length')) {
    function Sublimeplus_custom_excerpt_length()
    {
        return get_theme_mod('Sublimeplus_loop_excerpt_length', '30');
    }
}
add_filter('excerpt_length', 'Sublimeplus_custom_excerpt_length', 999);
/**
 * Change excerpt more
 *
 */
if (!function_exists('Sublimeplus_excerpt_more')) {
    function Sublimeplus_excerpt_more($more)
    {
        return '...';
    }
}
add_filter('excerpt_more', 'Sublimeplus_excerpt_more');

/**
 * Custom COMMENTS an Pings
 * Change template comment of wordpress by list comment of theme
 * @uses   use callback of wordpress comment
 * @return custom template list comment of theme
 **/
if (!function_exists('Sublimeplus_custom_comments')) {
    function Sublimeplus_custom_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $GLOBALS['comment_depth'] = $depth;
        ?>
        <li id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix') ?>>
        <div class="comment-wrap clearfix">
            <div class="comment-avatar">
                <?php if (function_exists('get_avatar')) {
                    echo wp_kses(get_avatar($comment, '60'), array('img' => array('class' => array(), 'width' => array(), 'height' => array(), 'alt' => array(), 'src' => array())));
                } ?>
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <?php
                    printf('<h5 class="author-name">%1$s</h5>',
                        get_comment_author_link()
                    );
                    echo '<span class="date-post">' . esc_html(get_comment_date('', get_comment_ID())) . '</span>';
                    ?>
                </div>
                <?php if ($comment->comment_approved == '0') wp_kses(__("\t\t\t\t\t<span class='unapproved'>" . esc_html__('Your comment is awaiting moderation.', 'sublimeplus') . "</span>\n", 'sublimeplus'), array('span' => array('class' => array()))); ?>
                <div class="comment-body">
                    <?php comment_text() ?>
                </div>
                <div class="comment-meta-actions">
                    <?php
                    edit_comment_link(esc_html__('Edit', 'sublimeplus'), '<span class="edit-link">', '</span>');
                    ?>
                    <?php if ($args['type'] == 'all' || get_comment_type() == 'comment') :
                        comment_reply_link(array_merge($args, array(
                            'reply_text' => esc_html__('Reply', 'sublimeplus'),
                            'login_text' => esc_html__('Log in to reply.', 'sublimeplus'),
                            'depth' => $depth,
                            'before' => '<span class="comment-reply">',
                            'after' => '</span>'
                        )));
                    endif; ?>
                </div>
            </div>
        </div>
    <?php }
}
if (!function_exists('Sublimeplus_custom_pings')) {
    function Sublimeplus_custom_pings($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $GLOBALS['comment_depth'] = $depth;
        ?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix') ?>>
        <div class="comment-wrap clearfix">
            <div class="comment-content">
                <div class="comment-meta">
                    <?php
                    printf('<h6 class="author-name">%1$s</h6>',
                        get_comment_author_link()
                    );
                    ?>
                </div>
                <?php if ($comment->comment_approved == '0') wp_kses("<span class='unapproved'>" . esc_html__('Your comment is awaiting moderation.', 'sublimeplus') . "</span>", array('span' => array('class' => array()))); ?>
                <div class="comment-meta-actions">
                    <?php
                    edit_comment_link(esc_html__('Edit', 'sublimeplus'), '<span class="edit-link">', '</span>');
                    ?>
                    <?php if ($args['type'] == 'all' || get_comment_type() == 'comment') :
                        comment_reply_link(array_merge($args, array(
                            'reply_text' => esc_html__('Reply', 'sublimeplus'),
                            'login_text' => esc_html__('Log in to reply.', 'sublimeplus'),
                            'depth' => $depth,
                            'before' => '<span class="comment-reply">',
                            'after' => '</span>'
                        )));
                    endif; ?>
                </div>
            </div>
        </div>
    <?php }
}
/**
 * Theme search form
 * Override default search form of wordpress by custom search form of theme
 * @uses apply_filters to get_search_form
 * @return Custom search form of theme.
 *
 */
if (!function_exists('Sublimeplus_custom_search_form')) {
    function Sublimeplus_custom_search_form($form)
    {
        $form = '<form method="get" id="searchform-' . esc_attr(mt_rand()) . '" class="custom-search-form search-form" action="' . esc_url(home_url('/')) . '" >
                <input type="text" placeholder="' . esc_attr__('Search…', 'sublimeplus') . '"  class="search-field" value="' . esc_attr(get_search_query()) . '" name="s" id="s-' . esc_attr(mt_rand()) . '" />
                <button type="submit" value="' . esc_attr__('Search', 'sublimeplus') . '"><i class="sublimeplus-icon-search"></i></button>
                </form>';

        return $form;
    }
}
add_filter('get_search_form', 'Sublimeplus_custom_search_form');

/**
 * Remove section unused.
 **/
if (!function_exists('Sublimeplus_site_customizer')) {
    function Sublimeplus_site_customizer($wp_customize)
    {
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('background_image');
        $wp_customize->remove_section('header_image');
    }
}
add_action('customize_register', 'Sublimeplus_site_customizer');

/**
 * Add preset for footer.
 * */
if (!function_exists('Sublimeplus_custom_footer_preset')) {
    function Sublimeplus_custom_footer_preset()
    {
        return [
            'default' => esc_html__('Default', 'sublimeplus'),
            'light' => esc_html__('Light', 'sublimeplus'),
            'dark' => esc_html__('Dark', 'sublimeplus'),
        ];
    }
}
add_filter('Sublimeplus_footer_preset', 'Sublimeplus_custom_footer_preset', 1);

/**
 * Add site meta for share.
 * */
if (!function_exists('Sublimeplus_meta')) {
    function Sublimeplus_meta()
    {
        global $wp;
        $Sublimeplus_url = home_url($wp->request);
        $Sublimeplus_meta = '';
        $Sublimeplus_img = get_theme_mod('Sublimeplus_site_featured_imaged', '');
        $Sublimeplus_img = $Sublimeplus_img != '' ? $Sublimeplus_img : get_theme_mod('custom_logo');
        $Sublimeplus_img = wp_get_attachment_url($Sublimeplus_img);
        $Sublimeplus_title = get_bloginfo('name');
        $Sublimeplus_des = get_bloginfo('description');
        if (!is_front_page()) {
            if (is_page() || is_single()) {
                $Sublimeplus_title = get_the_title();
                $Sublimeplus_des = apply_filters('the_excerpt', get_post_field('post_excerpt', get_the_ID()));;
                if (has_post_thumbnail()) {
                    $Sublimeplus_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                }
            }
            if (is_archive()) {
                $Sublimeplus_title = get_the_archive_title();
                $Sublimeplus_des = get_the_archive_description();
            }
            if (class_exists('WooCommerce')) {
                if (is_shop()) {
                    if (get_theme_mod('Sublimeplus_shop_cover_img_bg', '') != '') {
                        $Sublimeplus_img = get_theme_mod('Sublimeplus_shop_cover_img_bg', '');
                    }
                    if (get_theme_mod('Sublimeplus_shop_cover_text', '') != '') {
                        $Sublimeplus_title = get_theme_mod('Sublimeplus_shop_cover_text', '');
                    }
                }
                if (is_product_category()) {
                    global $wp_query;
                    $cat = $wp_query->get_queried_object();
                    if ($cat->description != '') {
                        $Sublimeplus_des = $cat->description;
                    }
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    if ($thumbnail_id) {
                        $Sublimeplus_img = wp_get_attachment_url($thumbnail_id);
                    }
                }
            }
        }
        $Sublimeplus_meta .= '<meta property="og:title" content="' . wp_strip_all_tags($Sublimeplus_title) . '">
    <meta property="og:description" content="' . esc_attr(strip_tags($Sublimeplus_des)) . '">
    <meta property="og:image" content="' . esc_url($Sublimeplus_img) . '">
    <meta property="og:url" content="' . esc_url($Sublimeplus_url) . '">';
        echo ent2ncr($Sublimeplus_meta);
    }
}
if(get_theme_mod('Sublimeplus_enable_site_meta',0)==1) {
	add_action( 'wp_head', 'Sublimeplus_meta' );
}
/**
 * Change categories count
 */
add_filter('wp_list_categories', 'Sublimeplus_cat_count_span');
add_filter('get_archives_link', 'Sublimeplus_cat_count_span');
if (!function_exists('Sublimeplus_cat_count_span')) {
    function Sublimeplus_cat_count_span($links)
    {
        $links = str_replace('</a>&nbsp;(', '</a> <span class="count">', $links);
        $links = str_replace('</a> (', '</a> <span  class="count">', $links);
        $links = str_replace(')', '</span>', $links);
        return $links;
    }
}

/***
 * Add Contact icon to site.
 *
*/
if (!function_exists('Sublimeplus_contact_icon')) {
    function Sublimeplus_contact_icon()
    {
        get_template_part('inc/templates/contact');
    }
}
add_action('Sublimeplus_after_main_content', 'Sublimeplus_contact_icon', 10);
if (class_exists('WooCommerce', false)) {
    add_action('woocommerce_after_main_content', 'Sublimeplus_contact_icon', 10);
}

/**
 * Add site meta for share.
 * */
if (!function_exists('Sublimeplus_meta')) {
    function Sublimeplus_meta()
    {
        global $wp;
        $Sublimeplus_url = home_url($wp->request);
        $Sublimeplus_meta = '';
        $Sublimeplus_img = get_theme_mod('Sublimeplus_site_featured_imaged', '');
        $Sublimeplus_img = $Sublimeplus_img != '' ? $Sublimeplus_img : get_theme_mod('custom_logo');
        $Sublimeplus_img = wp_get_attachment_url($Sublimeplus_img);
        $Sublimeplus_title = get_bloginfo('name');
        $Sublimeplus_des = get_bloginfo('description');
        if (!is_front_page()) {
            if (is_page() || is_single()) {
                $Sublimeplus_title = get_the_title();
                $Sublimeplus_des = apply_filters('the_excerpt', get_post_field('post_excerpt', get_the_ID()));;
                if (has_post_thumbnail()) {
                    $Sublimeplus_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                }
            }
            if (is_archive()) {
                $Sublimeplus_title = get_the_archive_title();
                $Sublimeplus_des = get_the_archive_description();
            }
            if (class_exists('WooCommerce')) {
                if (is_shop()) {
                    if (get_theme_mod('Sublimeplus_shop_cover_img_bg', '') != '') {
                        $Sublimeplus_img = get_theme_mod('Sublimeplus_shop_cover_img_bg', '');
                    }
                    if (get_theme_mod('Sublimeplus_shop_cover_text', '') != '') {
                        $Sublimeplus_title = get_theme_mod('Sublimeplus_shop_cover_text', '');
                    }
                }
                if (is_product_category()) {
                    global $wp_query;
                    $cat = $wp_query->get_queried_object();
                    if ($cat->description != '') {
                        $Sublimeplus_des = $cat->description;
                    }
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    if ($thumbnail_id) {
                        $Sublimeplus_img = wp_get_attachment_url($thumbnail_id);
                    }
                }
            }
        }
        $Sublimeplus_meta .= '<meta property="og:title" content="' . wp_strip_all_tags($Sublimeplus_title) . '">
    <meta property="og:description" content="' . esc_attr(strip_tags($Sublimeplus_des)) . '">
    <meta property="og:image" content="' . esc_url($Sublimeplus_img) . '">
    <meta property="og:url" content="' . esc_url($Sublimeplus_url) . '">';
        echo ent2ncr($Sublimeplus_meta);
    }
}
add_action('wp_head', 'Sublimeplus_meta');
/**
 * Add custom image size
 */
add_image_size('sublimeplus-medium-crop', 450, 450, true);
add_filter('image_size_names_choose', 'Sublimeplus_custom_img_sizes');
if(!function_exists('Sublimeplus_custom_img_sizes')){
	function Sublimeplus_custom_img_sizes($imgsizes)
	{
		return array_merge($imgsizes, array(
			'sublimeplus-medium-crop' => esc_html__('Custom Medium Crop', 'sublimeplus'),
		));
	}
}