<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package SublimePulse\Templates
 * @author   SublimePulse
 * @link     https://www.SublimePulse.com/
 *
 */

get_header();

/**
 * Zoo Before Main Content
 *
 * @hooked Sublimeplus_breadcrumb - 10
 * @hooked Sublimeplus_blog_cover - 20
 */
do_action('Sublimeplus_before_main_content');
?>
    <main id="site-main-content" class="<?php echo esc_attr(Sublimeplus_main_content_css()) ?>">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(Sublimeplus_loop_content_css()) ?>">
                    <?php
                    /**
                     * Zoo Before Loop Blog Content
                     *
                     */
                    do_action('Sublimeplus_before_loop_content');
                    ?>
                    <div class="row">
                        <?php if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('inc/templates/posts/loop/post', 'item');
                            endwhile;
                        else :
                            get_template_part('content', 'none');
                        endif; ?>
                    </div>
                    <?php
                    /**
                     * Zoo After Loop Blog Content
                     *@hooked Sublimeplus_post_pagination - 10
                     */
                    do_action('Sublimeplus_after_loop_content');
                    ?>
                </div>
                <?php get_sidebar();?>
            </div>
        </div>
    </main>
<?php
/**
 * Zoo After Main Content
 *
 */
do_action('Sublimeplus_after_main_content');
get_footer();