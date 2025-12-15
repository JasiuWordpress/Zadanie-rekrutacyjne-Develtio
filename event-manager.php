<?php
/**
 * Plugin Name: Wtyczka Rekrutacyjna Develtio
 * Plugin URI: https://develtio.com
 * Description: Wtyczka przygotowana jako zadanie rekrutacyjne. 
 * Version: 1.0.0
 * Author: Jan Pankowski
 * Author URI: https://linkedin.com
 *
 */


if ( ! defined( 'ABSPATH' ) ) {
	die();
}



require_once plugin_dir_path( __FILE__ ) . 'includes/cpt-registration.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/acf-fields.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/users.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/user_shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/enques.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/ajax-handlers.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/adminpage.php';



register_activation_hook( __FILE__, 'dl_activate' );

function dl_activate() {

	/* Sprawdzam czy jest acf */
	if ( ! class_exists( 'ACF' ) ) {

		deactivate_plugins( plugin_basename( __FILE__ ) );

		wp_die(
			'Wtyczka Event Manager wymaga aktywnej wtyczki Advanced Custom Fields.',
			'Błąd aktywacji',
			[ 'back_link' => true ]
		);
	}

	/* dodaje strone*/
	dl_create_account_page();

}





