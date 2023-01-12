<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register Events post type
add_action( 'init', 'register_cpt' );
function register_cpt() {
	register_post_type( 'events', array(
		'labels' => array(
			'name' => __( 'Events', 'recspec-events' ),
			'singular_name' => __( 'Event', 'recspec-events' ),
		),
		'public' => true,
		'has_archive' => false,
		'menu_icon' => 'dashicons-calendar-alt',
		'publicly_queryable' => false,
		'rewrite' => false,
		'show_ui' => true,
		'supports' => array(
			'title',
			'thumbnail',
		),
		'taxonomies' => array( 'post_tag' ),
	));
}
