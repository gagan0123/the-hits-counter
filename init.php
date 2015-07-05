<?php

/*
  Plugin Name: The Hits Counter
  Plugin URI: http://blogs.gagan.pro/hits-counter/
  Description: Checks and displays the number of hits for posts
  Author: Gagan Deep Singh
  Version: 1.0
  Author URI: http://gagan.pro
 */

/*
 * Runs at the init of every page and checks when to add the counters
 */

function thc_hits_logic() {
    if (is_single() && get_the_ID() > 0) {
        thc_add_counter(get_the_ID());
    }
}

add_action('wp', 'thc_hits_logic');

/*
 * Adds the counter of the post
 */

function thc_add_counter($post_id) {
    if ($post_id == null || $post_id < 1) {
        return;
    }
    $counter = get_post_meta($post_id, 'thc_hits_counter', true);
    if (empty($counter)) {
        $counter = 0;
    }
    $counter = intval($counter);
    $counter++;
    update_post_meta($post_id, 'thc_hits_counter', $counter);
}

/*
 * Displays the hits that are counted on the post
 */

function thc_display_count($post_id = null) {
    echo apply_filters('thc_display_count',thc_get_count($post_id));
}

/*
 * Returns the count for the given post id
 */

function thc_get_count($post_id = null) {
    if ($post_id == null) {
        $post_id = get_the_ID();
    }
    $counter = get_post_meta($post_id, 'thc_hits_counter',true);
    if (empty($counter)) {
        $counter = 0;
    }
    $counter = intval($counter);
    return $counter;
}
add_shortcode('thc_hits_count', 'thc_get_count');

function thc_counter_pre_text($count){
    return '<span class="hits-counter">Hits : '.$count.'</span>';
}
add_filter('thc_display_count','thc_counter_pre_text');