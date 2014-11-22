<div class="sidebar">
<div class="list">

<h2 class="content">НАШІ КУРСИ</h2>
<ul class="details">
<?php


$args = array( 'category_name' => "course" , 'posts_per_page' => -1, 'order'=> 'ASC');

$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
    <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </li>
<?php endforeach;
wp_reset_postdata();?>

</ul>
</div>
</div>