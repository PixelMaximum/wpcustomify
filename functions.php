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
	wp_enqueue_style('wpcustomify-typekit', 'https://use.typekit.net/xlx8wfz.css');
	wp_enqueue_style('wpcustomify-style', get_stylesheet_directory_uri() .'/style.css', array('customify-style'));
}

/* Support 3-rd plugins. */

// Wedocs (Inspiration from freemius guide: https://freemius.com/blog/build-knowledge-base-documentation )
$wedocs_file = trailingslashit( get_stylesheet_directory() ) . 'compatibility/wedocs/wedocs.php';
if ( is_readable( $wedocs_file ) && class_exists('WeDocs') ) {
	require_once $wedocs_file;
}

// Gravity Forms
$gforms_file = trailingslashit( get_stylesheet_directory() ) . 'compatibility/gravity_forms.php';
if ( is_readable( $gforms_file ) && class_exists('GFForms') ) {
	require_once $gforms_file;
}


function customify_wedocs_layout( $layout ){

    if ( is_singular( 'docs' ) ) {
        return 'content';
    }
    return $layout;
}
add_filter( 'customify_get_layout', 'customify_wedocs_layout' ) ;


function customify_edd_dashboad_url( $url ){
    if ( isset( $GLOBALS['_customify_tab'] ) ) {
        $url = remove_query_arg( ( array( 'tab') ), $url );
        return add_query_arg( array( 'tab' => $GLOBALS['_customify_tab'] ), $url );
    }
    return $url;
}

add_filter( 'edd_get_current_page_url', 'customify_edd_dashboad_url', 35 );
add_filter( 'edd_subscription_update_url', 'customify_edd_dashboad_url', 35 );
add_filter( 'edd_subscription_cancel_url', 'customify_edd_dashboad_url', 35 );
add_filter( 'edd_subscription_reactivation_url', 'customify_edd_dashboad_url', 35 );

/**
 * Displays a Manage Licenses link in purchase history
 *
 * @since 2.7
 */
function customify_edd_sl_site_management_links( $payment_id, $purchase_data ) {

    $licensing = edd_software_licensing();
    $downloads = edd_get_payment_meta_downloads( $payment_id );
    if( $downloads) :

        $manage_licenses_url = add_query_arg( array( 'action' => 'manage_licenses', 'payment_id' => $payment_id ) );
        if ( isset( $GLOBALS['_customify_tab'] ) ) {
            $manage_licenses_url = remove_query_arg( ( array( 'tab') ), $manage_licenses_url );
            $manage_licenses_url = add_query_arg( array( 'tab' => 'license-keys' ), $manage_licenses_url );
        }

        $manage_licenses_url  = esc_url( $manage_licenses_url );

        echo '<td class="edd_license_key">';
        if( edd_is_payment_complete( $payment_id ) && $licensing->get_licenses_of_purchase( $payment_id ) ) {
            echo '<a href="' . esc_url( $manage_licenses_url ) . '">' . __( 'View Licenses', 'edd_sl' ) . '</a>';
        } else {
            echo '-';
        }
        echo '</td>';
    else:
        echo '<td>&mdash;</td>';
    endif;
}

remove_action( 'edd_purchase_history_row_end', 'edd_sl_site_management_links', 10, 2 );
add_action( 'edd_purchase_history_row_end', 'customify_edd_sl_site_management_links', 15, 2 );


