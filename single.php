<?php
/**
 * The template for displaying all single posts.
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 */


get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        /**
         * Zoo Before Main Content
         *
         * @hooked Sublimeplus_breadcrumb - 10
         * @hooked Sublimeplus_blog_cover - 20
         */
        do_action('Sublimeplus_before_main_content');
        ?>
        <main id="site-main-content" class="<?php echo esc_attr(Sublimeplus_main_content_css()) ?>">
            <?php
            /**
             * Zoo Before Single Blog Content
             *
             */
            do_action('Sublimeplus_before_single_main_content');
            ?>
            <div class="container">
                <div class="row">
                    <div class="<?php echo esc_attr(Sublimeplus_single_content_css()) ?>">
                        <?php
                        get_template_part('content', 'single');
                        ?>
                    </div>
                    <?php
                    get_sidebar('single');
                    ?>
                </div>
            </div>
            <?php
            /**
             * Zoo After Loop Single Content
             *
             */
            do_action('Sublimeplus_after_single_main_content');
            ?>
        </main>
        <?php

        /**
         * Zoo After Main Content
         *
         */
        do_action('Sublimeplus_after_main_content');
    endwhile;
endif;
get_footer();
