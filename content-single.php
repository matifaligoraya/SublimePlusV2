<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package     SublimePulse
 * @version     1.0.0
 * @author      SublimePulse
 * @link     https://bitandbytelab.com/
 * @copyright   Copyright (c) 2020 SublimePulse
 */

?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-detail'); ?>>
        <div class="header-post">
            <?php

            /**
             * Zoo Before Single Blog Content
             * Sublimeplus_single_post_sticky_label 10
             */
            do_action('Sublimeplus_before_single_post_title');
            ?>
            <h1 class="title-detail"><?php
                the_title();
                Sublimeplus_single_post_sticky_label();
                ?>
            </h1>
            <?php
            /**
             * Zoo Before Single Blog Content
             * Sublimeplus_single_post_info 10
             *
             */
            do_action('Sublimeplus_after_single_post_title');
            ?>
        </div>
        <?php
        /**
         * Before single content post
         * Sublimeplus_single_post_media 10
         *
         */
        do_action('Sublimeplus_before_single_content');
        ?>
        <div class="post-content">
            <?php
            the_content();
            ?>
        </div>
        <?php
        /**
         * Before after content post
         * Sublimeplus_single_post_pagination 10
         * Sublimeplus_single_post_bottom_content 20
         */
        do_action('Sublimeplus_after_single_content');
        ?>
    </article>
<?php
/**
 * Bottom single post
 * Sublimeplus_single_post_about_author 10
 * Sublimeplus_single_post_navigation 20
 */
do_action('Sublimeplus_single_post_bottom');

// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()) :
    comments_template('', true);
endif;