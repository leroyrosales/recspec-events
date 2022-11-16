<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Events query shortcode
add_shortcode( 'recspec_events', 'recspec_events_query_events' );
function recspec_events_query_events() {
	ob_start();

	global $paged;

	// Get the current date
	$date_now = gmdate( 'Y-m-d H:i:s' );
	$time_now = strtotime( $date_now );
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	$date_args = array(
		'post_type'      => 'events',
		'meta_key'       => 'event_start_time',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'paged' => $paged,
		'meta_query'     => array(
			array(
				'key'     => 'event_start_time',
				'compare' => '>',
				'value'   => date( "Y-m-d" ),
				'type'    => 'DATETIME',
			),
		),
	);

	$date_query = new WP_Query( $date_args );

	echo '<ul>';
		while ( $date_query->have_posts() ) : $date_query->the_post();

			// Get the custom fields
			$event_start_time = get_field( 'event_start_time' );
			$event_end_time   = get_field( 'event_end_time' );
			$content          = get_field( 'content' );
			$ticket_link      = get_field( 'ticket_link' );

			echo '<li>';

			echo get_the_post_thumbnail();

			echo '<h2>' . sanitize_text_field( get_the_title() ) . '</h2>';
			if ( $event_start_time ) :
				echo '<h3>' . $event_start_time . '</h3>';
			endif;
			if ( $event_end_time ) :
				echo '<h3>' . $event_end_time . '</h3>';
			endif;
			if ( $ticket_link ) :
				echo '<a href="' .  sanitize_text_field( $ticket_link['url'] ) . '" target="' . $ticket_link['target'] . '">' .  sanitize_text_field( $ticket_link['title'] ) . '</a>';
			endif;
			if (  $content ) :
				echo $content;
			endif;

			echo '</li>';
		endwhile;
	echo '</ul>'; ?>

	<div class="nav-previous alignleft"><?php previous_posts_link( 'Older events' ); ?></div>
	<div class="nav-next alignright"><?php next_posts_link( 'Newer events', $date_query->max_num_pages ); ?></div>

	<?php
	wp_reset_postdata();

	return ob_get_clean();
}


