<?php
/**
 * FK Custom post types
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'fk_custom_post_types' );

function fk_custom_post_types() {

    register_post_type( 'raatilaiset', array(
    'labels' => array(
        'name' => 'Raatilaiset',
        'singular_name' => 'Raatilainen',
    ),
    'description' => 'Killan raatilaiset.',
    'public' => true,
    'menu_position' => 20,
    'menu_icon'           => 'dashicons-groups',
    'supports' => array( 'title', 'editor', 'custom-fields' )
    ));
}