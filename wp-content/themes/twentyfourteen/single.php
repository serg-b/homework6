<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<div id="content">
    <?php
    get_sidebar( 'details' );
    ?>

    <div class="details">
        <ul>
            <li style="display: list-item;">
                <?php the_post_thumbnail()?>
                <h2><?php the_title(); ?></h2>
                <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();
                    the_content();
                    $title = get_the_title();
                endwhile;
                ?>
                <h3>Команда</h3>
                    <?php
                    $title = sanitize_title($title);

                    $the_query = new WP_Query( "tag={$title}" );
                    if ( $the_query->have_posts() ) {
                        echo '<ul class="team">';
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post(); ?>

                            <li>
                                <?php //var_dump($the_query->posts[0]); ?>
                                <?php echo $the_query->posts[0]->post_content ?>
                            </li>
                        <?php }
                        echo '</ul>';
                    }
                    ?>
                </ul>
                <a class="register" href="/register">Зареєструватися</a>
            </li>
        </ul>
    </div>



</div>

<?php
get_footer();
