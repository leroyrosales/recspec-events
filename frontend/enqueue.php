<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function register_recspec_events_styles() {
    wp_enqueue_style( 'recspec_events_styles', plugin_dir_url( __FILE__ ) . '/css/recspec-events-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'register_recspec_events_styles' );
