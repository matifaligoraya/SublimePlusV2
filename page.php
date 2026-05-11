<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
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
    <main id="site-main-content" class="main-content">
        <?php while (have_posts()) : the_post();
            ?>
            <div class="container">
                <?php
                get_template_part('content', 'page');
                if (comments_open() || get_comments_number()) :
                    comments_template('', true);
                endif;
                ?>
            </div>
        <?php
        endwhile; ?>
    </main>
<?php
/**
 * Zoo After Main Content
 *
 */
do_action('Sublimeplus_after_main_content');
get_footer();
