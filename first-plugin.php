<?php
/*
Plugin name: First Plugin
Description: This plugin will add a new post type 'Events' publish some events and use shortcode [all_events] on any page to display events
Version: 1.0.0
Author: Muhammad Qurban
Author URI: qurban.com
*/

function icodeguru_events() {

    register_post_type( 'event', array(
        'public'    => true,
        'supports'  => array('title', 'editor', 'excerpt'),
        'labels'    => array(
            'name'          => 'Events',
            'add_new'       => 'Add New',
            'add_new_item'  => 'Add New Event',
            'all_items'     => 'All Events',
            'edit_item'     => 'Edit Event',
        ),
        'menu_icon' => 'dashicons-calendar'
    ) );
}

add_action( 'init', 'icodeguru_events' );

function icodeguru_events_shortcode() {
    $events_query = new WP_Query(array(
        'post_type'      => 'event',
        'posts_per_page' => -1, 
    ));

    $output = '';

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $output .= '
                <h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                <p>' . get_the_excerpt() . '</p>
                <p>' . get_the_date() . '</p>
                <p>' . get_the_author() . '</p>
                <a href="' . get_the_permalink() . '">Click to see details</a>
                <hr>
            ';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No events found</p>';
    }
    
    return $output;
    
}

add_shortcode('all_events', 'icodeguru_events_shortcode');
?>
