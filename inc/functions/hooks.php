<?php
/**
 * Hooks of Blog
 * All templates of theme will load by hook. User can change order and location at custom file.
 *
 */

/**
 * Hook follow blog layout
 * */
add_action('Sublimeplus_before_post_item', 'Sublimeplus_post_item_thumbnail', 20);

/**
 * Sublimeplus_breadcrumb
 * Get template breadcrumb
 * @uses use function and hook to Sublimeplus_before_main_content
 * */
if (!function_exists('Sublimeplus_breadcrumb')) {
    function Sublimeplus_breadcrumb()
    {
        get_template_part('inc/templates/breadcrumbs');
    }
}
add_action('Sublimeplus_before_main_content', 'Sublimeplus_breadcrumb', 10);

/**
 * Sublimeplus_blog_cover
 * Get template blog cover
 * @uses use function and hook to Sublimeplus_before_main_content
 * */
if (!function_exists('Sublimeplus_blog_cover')) {
    function Sublimeplus_blog_cover()
    {
        get_template_part('inc/templates/posts/blog', 'cover');
    }
}
add_action('Sublimeplus_before_main_content', 'Sublimeplus_blog_cover', 20);


/**
 * Sublimeplus_post_pagination
 * Get template post pagination for loop
 * @uses use function and hook to Sublimeplus_before_main_content
 * */
if (!function_exists('Sublimeplus_post_pagination')) {
    function Sublimeplus_post_pagination()
    {
        get_template_part('inc/templates/posts/post', 'pagination');
    }
}
add_action('Sublimeplus_after_loop_content', 'Sublimeplus_post_pagination', 10);

/**
 * Sublimeplus_post_item_thumbnail
 * Get template post item thumbnail for loop
 * @uses use function and hook to Sublimeplus_post_item_thumbnail
 * */
if (!function_exists('Sublimeplus_post_item_thumbnail')) {
    function Sublimeplus_post_item_thumbnail()
    {
        get_template_part('inc/templates/posts/loop/thumbnail');
    }
}
/**
 * Sublimeplus_post_item_info
 * Get template post item thumbnail for loop
 * @uses use function and hook to Sublimeplus_post_item_thumbnail
 * */
if (!function_exists('Sublimeplus_post_item_info')) {
    function Sublimeplus_post_item_info()
    {
        get_template_part('inc/templates/posts/loop/post', 'info');;
    }
}
/**
 * Sublimeplus_post_item_cat
 * Get template post item thumbnail for loop
 * @uses use function and hook to Sublimeplus_post_item_thumbnail
 * */
if (!function_exists('Sublimeplus_post_item_cat')) {
    function Sublimeplus_post_item_cat()
    {
        if (get_theme_mod('Sublimeplus_blog_layout', 'list') == 'grid' || get_theme_mod('Sublimeplus_blog_layout', 'list') == 'masonry') {
            if (!has_post_thumbnail()) {
                get_template_part('inc/templates/posts/global/sticky');
            }
        }
        if (get_theme_mod('Sublimeplus_enable_loop_cat_post', '1') == 1) {
            ?>
            <div class="list-cat">
                <?php if (get_theme_mod('Sublimeplus_blog_loop_post_info_style', '') == 'icon') { ?>
                    <i class="cs-font clever-icon-document"></i>
                    <?php
                }
                echo get_the_term_list(get_the_ID(), 'category', '', ', ', ''); ?></div>
        <?php }
    }
}
add_action('Sublimeplus_before_post_item_title', 'Sublimeplus_post_item_cat', 20);

/**
 * Sublimeplus_post_item_readmore
 * Get template post item thumbnail for loop
 * @uses use function and hook to Sublimeplus_post_item_readmore
 * */
if (!function_exists('Sublimeplus_post_item_readmore')) {
    function Sublimeplus_post_item_readmore()
    {
        if (get_theme_mod('Sublimeplus_enable_loop_readmore', '1') == 1 || get_the_title() == '') {
            ?>
            <a href="<?php echo esc_url(the_permalink()); ?>"
               class="readmore"><?php echo esc_html__('Read more', 'sublimeplus'); ?><i class="cs-font clever-icon-arrow-right-5"></i> </a>
            <?php
        }
    }
}
add_action('Sublimeplus_after_post_item', 'Sublimeplus_post_item_readmore', 10);

/**---------------------------------------------------------
 *----------------------SINGLE POST------------------------
 *----------------------------------------------------------*/

/**
 * Sublimeplus_single_post_sticky_label
 * Get sticky label template
 * */
if (!function_exists('Sublimeplus_single_post_sticky_label')) {
    function Sublimeplus_single_post_sticky_label()
    {
        get_template_part('inc/templates/posts/global/sticky');
    }
}
/**
 * Sublimeplus_single_post_category
 * Get sticky label template
 * @uses hook to Sublimeplus_before_single_post_title
 * */
if (!function_exists('Sublimeplus_single_post_category')) {
    function Sublimeplus_single_post_category()
    {
        get_template_part('inc/templates/posts/single/post','cat');
    }
}
add_action('Sublimeplus_before_single_post_title', 'Sublimeplus_single_post_category', 10);

/**
 * Sublimeplus_single_post_sticky_label
 * Get sticky label template
 * @uses hook to Sublimeplus_before_single_post_title
 * */
if (!function_exists('Sublimeplus_single_post_info')) {
    function Sublimeplus_single_post_info()
    {
        get_template_part('inc/templates/posts/single/post-info');
    }
}
add_action('Sublimeplus_after_single_post_title', 'Sublimeplus_single_post_info', 10);

/**
 * Sublimeplus_single_post_media
 * Get media template of single post
 * @uses hook to Sublimeplus_before_single_content
 * */
if (!function_exists('Sublimeplus_single_post_media')) {
    function Sublimeplus_single_post_media()
    {
        get_template_part('inc/templates/posts/single/media');
    }
}
add_action('Sublimeplus_before_single_content', 'Sublimeplus_single_post_media', 10);

/**
 * Sublimeplus_single_post_gallery
 * Get media template of single post
 * @uses hook to Sublimeplus_before_single_content
 * */
if (!function_exists('Sublimeplus_single_post_gallery')) {
    function Sublimeplus_single_post_gallery()
    {
        get_template_part('inc/templates/posts/single/gallery');
    }
}
add_action('Sublimeplus_before_main_content', 'Sublimeplus_single_post_gallery', 10);

/**
 * !IMPORTANT This is default feature of WP, don't remove.
 * Sublimeplus_single_post_pagination
 * Get pagination template of single post
 * @uses hook to Sublimeplus_after_single_content
 * */
if (!function_exists('Sublimeplus_single_post_pagination')) {
    function Sublimeplus_single_post_pagination()
    {
        get_template_part('inc/templates/pagination', 'detail');
    }
}
add_action('Sublimeplus_after_single_content', 'Sublimeplus_single_post_pagination', 10);

/**
 * Sublimeplus_single_post_bottom_content
 * Get bottom post template of single post
 * Display share, tag, category.
 * @uses hook to Sublimeplus_after_single_content
 * */
if (!function_exists('Sublimeplus_single_post_bottom_content')) {
    function Sublimeplus_single_post_bottom_content()
    {
        get_template_part('inc/templates/posts/single/bottom-post-content');
    }
}
add_action('Sublimeplus_after_single_content', 'Sublimeplus_single_post_bottom_content', 20);

/**
 * Sublimeplus_single_post_about_author
 * Get temple about post author
 * Display post author.
 * @uses hook to Sublimeplus_single_post_bottom
 * */
if (!function_exists('Sublimeplus_single_post_about_author')) {
    function Sublimeplus_single_post_about_author()
    {
        get_template_part('inc/templates/posts/single/about', 'author');
    }
}
add_action('Sublimeplus_single_post_bottom', 'Sublimeplus_single_post_about_author', 10);

/**
 * Sublimeplus_single_post_navigation
 * Get template post navigation
 * Display next and previous post.
 * @uses hook to Sublimeplus_single_post_bottom
 * */
if (!function_exists('Sublimeplus_single_post_navigation')) {
    function Sublimeplus_single_post_navigation()
    {
        get_template_part('inc/templates/posts/single/post', 'navigation');
    }
}
add_action('Sublimeplus_single_post_bottom', 'Sublimeplus_single_post_navigation', 20);

/**
 * Sublimeplus_single_post_related
 * Get template related posts
 * Display related posts.
 * @uses hook to Sublimeplus_single_post_bottom
 * */
if (!function_exists('Sublimeplus_single_post_related')) {
    function Sublimeplus_single_post_related()
    {
        get_template_part('inc/templates/posts/single/related', 'posts');
    }
}
add_action('Sublimeplus_after_single_main_content', 'Sublimeplus_single_post_related', 10);



