<?php
/**  */

get_header();

?>
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <?php
            // Start the Loop.
            if (have_posts()) :  the_post();
                the_title();
            the_content();

            endif;
            ?>


        </div><!-- #content -->

    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
