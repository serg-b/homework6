<?php
/*
    Plugin Name: Arzamath_17th
    Plugin URI:
    Description: This is slider plugin, You can choose images and pages where they should display, also at settings you can change slide changing interval and speed of the scroll animation. FOr the moment it displays after header , calls with functions echo_slider() at header.php
     Version: 1.0
    Author: l3xx
    Author URI: http://vk.com/sergey.lexx

    Copyright 2014 l3xx  (email: vc.l3xx@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function myplugin_activate() {

}

function register_my_custom_menu_page(){
    add_submenu_page( 'edit.php?post_type=slide', 'Settings', 'Settings', 'manage_options', 'arzamath_17th/settings.php', '' );
}

register_activation_hook( __FILE__, 'myplugin_activate' );

// Register custom post type

add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'slide',
        array(
            'labels' => array(
                'name' => 'Slides' ,
                'singular_name' => 'Slide'
            ),
            'public'   => true,
            'supports' => array ( 'title', 'thumbnail')
        )
    );
}

// Adding meta boxes

add_action('add_meta_boxes_slide', 'custom_meta_box');
function custom_meta_box(){
    add_meta_box('test_metabox', 'Pages list', 'test_function', 'slide', 'normal');
}

function test_function($post){
    $posts = new WP_Query(array(
        'post_status' => 'publish',
        'post_type' => 'page',
        'posts_per_page' => -1
    ));

    if ($posts->post_count>0) {
        $post_meta = get_post_meta($post->ID, 'display_on', true);
        //var_dump($post_meta);
        $post_meta = unserialize($post_meta);

        foreach($posts->posts as $post) {
            $is_checked = in_array($post->ID, $post_meta);
            ?>
            <p>
                <input type='checkbox' value='<?php echo $post->ID ?>'
                       name='display_on[]' <?php echo ($is_checked) ? 'checked' : '' ?>/>
                <?php echo $post->post_title ?>
            </p>
        <?php }
    }
}

add_action('save_post', 'save_display_on');
function save_display_on($post_id) {
    if (wp_is_post_revision($post_id)) {
        return;
    }

    //var_dump($_POST);
    //die;

    if (!empty($_POST['display_on'])) {
        $data4save = serialize($_POST['display_on']);
        update_post_meta($post_id, 'display_on', $data4save);
    }
}

if (!is_admin()) {
    function theme_name_scripts() {
        //wp_enqueue_style( 'style-name', get_stylesheet_uri() );
        wp_enqueue_script('jquery');
    }
    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
}

function echo_slider(){
        global $post;
        $slides = new WP_Query(array(
            'post_status' => 'publish',
            'post_type' => 'slide',
            'posts_per_page' => -1
        ));

        if ($slides->post_count > 0) {
            foreach ($slides->posts as $id) {
                $post_meta = get_post_meta($id->ID, 'display_on', true);
                //var_dump($post_meta);
                $post_meta = unserialize($post_meta);
            }
        }
        $id_check = in_array($post->ID, $post_meta);
        if ($id_check) {
            ?>
            <div class="jcarousel">
                <ul>
                    <?php while ($slides->have_posts()) {
                        $slides->the_post(); ?>
                        <li>
                            <?php the_post_thumbnail('full'); ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <script src="/wp-content/plugins/arzamath_17th/js/jquery.jcarousel.min.js" s></script>
            <script>
                jQuery(document).ready(function() {
                    jQuery('.jcarousel').jcarousel({
                        wrap: 'circular',
                        animation: '<?php echo get_option('fading'); ?>'
                    }).jcarouselAutoscroll({
                        interval: '<?php echo get_option('interval'); ?>',
                        autostart: true
                    });
                });
            </script>
        <?php }
}
