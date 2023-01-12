<?php

/*
 * Add columns to events post list
 */
function add_acf_columns( $columns ) {
	return array_merge(
		$columns,
		array(
			'event_start_time' => __( 'Start time' ),
			'event_end_time'   => __( 'End time' ),
		)
	);
}
add_filter( 'manage_events_posts_columns', 'add_acf_columns' );

 /*
 * Add columns to events post list
 */
function exhibition_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'event_start_time':
			echo get_field( 'event_start_time', $post_id );
		break;
		case 'event_end_time':
			echo get_field( 'event_end_time', $post_id );
		break;
	}
}
add_action( 'manage_events_posts_custom_column', 'exhibition_custom_column', 10, 2 );
