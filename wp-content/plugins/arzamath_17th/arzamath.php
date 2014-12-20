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
        $post_meta = unserialize($post_meta);

        foreach($posts->posts as $post) {
            $is_checked = in_array($post->ID, $post_meta);
            ?>
            <p>
                <input type='checkbox' value='<?php echo $post->ID ?>'
                       name='display_on[]' <?php echo ($is_checked) ? 'checked' : '' ?>/>
                <?php echo $post->post_title ?>
            </p>

        <?php } ?>
        <input type="button" id="savedata" name="Save" value="Save"/>
    <?php }
}

add_action('save_post', 'save_display_on');
function save_display_on($post_id) {
    if (wp_is_post_revision($post_id)) {
        return;
    }


    if (!empty($_POST['display_on'])) {
        $data4save = serialize($_POST['display_on']);

    // Add or Update the meta field in the database.
        if ( !update_post_meta($post_id, 'display_on', $data4save) ) {
            add_post_meta($post_id, 'display_on', $data4save, true );
        }

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
    $current_page_id = $post->ID;
    $flag_slide_exist = false;
    if ($slides->post_count > 0) {
        foreach ($slides->posts as $id) {
            $post_meta = get_post_meta($id->ID, 'display_on', true);
            $post_meta = unserialize($post_meta);
            if ( in_array($current_page_id, $post_meta) ) {
                $flag_slide_exist = true;
            }
        }
    }

    if ($flag_slide_exist) :
        ?>
        <div class="jcarousel">
            <ul>
                <?php

                    while ($slides->have_posts()) {
                    $slides->the_post();
                        $post_meta = get_post_meta($post->ID, 'display_on', true);
                        $post_meta = unserialize($post_meta);
                        if ( in_array($current_page_id, $post_meta) ) :
                        ?>
                    <li>
                        <?php the_post_thumbnail('full'); ?>
                    </li>
                <?php endif; } ?>
            </ul>
        </div>
        <script src="/wp-content/plugins/arzamath_17th/js/jquery.jcarousel.min.js"></script>
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
    <?php endif;
}

//AJAX

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            $('#savedata').click(function(e) {
                e.preventDefault();
                var data_field = [];
                var data_object = {};


                $('.inside input[type="checkbox"]:checked').each(function(i) {
                    data_field.push(
                        $(this).val()
                        );
                    }
                );

                data_object.data_field = data_field;
                data_object.post_id = $('#post_ID').val();
                var data = {
                    'action': 'my_action',
                    'data': data_object
                };

                $.post(ajaxurl, data, function(response) {
                    alert(response);
                })

            });

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

        });
    </script> <?php
}


add_action( 'wp_ajax_my_action', 'my_action_callback' );

function my_action_callback() {
    global $wpdb; // this is how you get access to the database

    $data_object = ($_POST['data']);
    $data_field = serialize( $data_object['data_field'] );


    if (!empty($data_object)) {

        if (wp_is_post_revision($data_object['post_id'])) {
            return "some";
        }


            // Add or Update the meta field in the database.
            $flag = false;
            $flag = update_post_meta($data_object['post_id'], 'display_on' , $data_field);
            if ( !$flag ) {
                $flag = add_post_meta($data_object['post_id'], 'display_on' , $data_field, true );
            }
            else {
                $flag = true;
            }

      // }

    }
    if ($flag){
        echo "Your data has been successfully saved";
    }
    else {
        echo "It was en error while saving your data";
    }


    die(); // this is required to terminate immediately and return a proper response
}