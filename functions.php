<?php
/**
 * WPCustomify functions and definitions.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable unuseful metadata

// Disable emoji.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Cleanup RPC.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

// Cleanup oembed.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove WP generator meta.
remove_action( 'wp_head', 'wp_generator' );

// Disable XML RPC
add_filter( 'xmlrpc_methods', function ( $methods ) {
	unset( $methods['pingback.ping'] );
	return $methods;
} );

// Enqueue child theme style
add_action( 'wp_enqueue_scripts', 'wpcustomify_enqueue_styles' );
function wpcustomify_enqueue_styles() {
	wp_enqueue_style('wpcustomify-style', get_stylesheet_directory_uri() .'/style.css', array('customify-style'));
}

/* Support 3-rd plugins. */

// Wedocs (Inspiration from freemius guide: https://freemius.com/blog/build-knowledge-base-documentation )
$wedocs_file = trailingslashit( get_stylesheet_directory() ) . 'compatibility/wedocs/wedocs.php';
if ( is_readable( $wedocs_file ) ) {
	require_once $wedocs_file;
}

