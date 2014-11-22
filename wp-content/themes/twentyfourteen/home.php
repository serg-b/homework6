<?php
/**
 * /**
 * Template Name: Home
 * User: l3xx
 * Date: 06.11.14
 * Time: 13:24
 */


get_header(); ?>

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <?php
            // Start the Loop.
            if (have_posts()) :  the_post();
                the_content();
            endif;
            ?>
            <ul class="details">
                <?php


                $args = array( 'category_name' => "course" , 'posts_per_page' => -1, 'orderby' => 'ID', 'order'=> 'ASC');

                $myposts = get_posts( $args );
                $left_col = 0;
                foreach ( $myposts as $post ) : setup_postdata( $post );
                    if ($left_col%3==0) {
                        $class="left-col";
                    } else {
                        $class="";
                    }
                    ?>
                    <li class="courses <?php echo $class ?>">
                        <?php the_post_thumbnail()?>
                        <a href="<?php the_permalink(); ?>"><h3 class="course_title"><?php the_title(); ?></h3></a>
                        <?php the_content() ?>
                        <a class="registration" href="<?php the_permalink(); ?>">Докладніше + реєстрація</a>
                    </li>
                <?php
                $left_col++;
                endforeach;
                wp_reset_postdata();?>

            </ul>

        </div><!-- #content -->
    </div><!-- #primary -->
    <div><?php dynamic_sidebar( 'sidebar-3' ); ?></div>

<?php
get_footer();
