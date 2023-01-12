<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Events query shortcode
add_shortcode( 'recspec_events', 'recspec_events_query_events' );
function recspec_events_query_events() {
	ob_start();

	global $paged, $post;

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
		'orderby'        => 'meta_value meta_value_num',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'event_start_time',
				'compare' => '>=',
				'value'   => date( 'Y-m-d', strtotime( '-12 hours' ) ),
				'type'    => 'DATE',
			),
		),
		'paged' => $paged,
	);

	$date_query = new WP_Query( $date_args );

	echo '<ul class="recspec-events">';
		while ( $date_query->have_posts() ) : $date_query->the_post();

			// Get the custom fields
			$event_start_time = get_field( 'event_start_time' );
			$event_end_time   = get_field( 'event_end_time' );
			$content          = get_field( 'content' );
			$ticket_link      = get_field( 'ticket_link' );
			$attachment_id    = get_post_thumbnail_id( $post->ID );

			?>

			<li class="recspec-events--event<?php echo ( has_post_thumbnail() ) ? ' has-img' : ''; ?>">

			<?php
			if ( has_post_thumbnail() ) {
				if ( $ticket_link ) { ?>
					<a href="<?php echo sanitize_text_field( $ticket_link['url'] ); ?>" target="<?php echo sanitize_text_field( $ticket_link['target'] ); ?>">
						<img
							src="<?php echo wp_get_attachment_image_url( $attachment_id, 'large' ); ?>"
							srcset="<?php echo wp_get_attachment_image_srcset( $attachment_id ); ?>"
							sizes="<?php echo wp_get_attachment_image_sizes( $attachment_id, 'medium' ); ?>"
						/>
					</a>
				<?php } else { ?>
					<img
						src="<?php echo wp_get_attachment_image_url( $attachment_id, 'large' ); ?>"
						srcset="<?php echo wp_get_attachment_image_srcset( $attachment_id, 'medium' ); ?>"
						sizes="<?php echo wp_get_attachment_image_sizes( $attachment_id, 'medium' ); ?>"
					/>
				<?php
				}
			}
			echo '<div>';
			echo '<h2>' . sanitize_text_field( get_the_title() ) . '</h2>';
			echo ''; ?>
			<div class="information">

				<time><h3><?php if ( $event_start_time ) { echo $event_start_time; } ?> <?php if ( $event_end_time ) { echo '&mdash;' . $event_end_time; } ?></h3></time>
				<?php if ( $ticket_link ) { echo '&plus; <a href="' .  sanitize_text_field( $ticket_link['url'] ) . '" target="' . $ticket_link['target'] . '">' .  sanitize_text_field( $ticket_link['title'] ) . '</a>'; } ?>
			</div>
			<?php
			if (  $content ) { ?>
				<div class="recspec-events--event-content"><?php echo $content; ?></div>
			<?php }
			echo '</div>';
			echo '</li>';
		endwhile;
	echo '</ul>'; ?>

	<nav class="recspec-events--nav">
		<div class="nav-previous"><?php previous_posts_link( '&laquo; Previous' ); ?></div>
		<div class="nav-next"><?php next_posts_link( 'Next &raquo;', $date_query->max_num_pages ); ?></div>
	</nav>

	<?php
	wp_reset_postdata();

	return ob_get_clean();
}
