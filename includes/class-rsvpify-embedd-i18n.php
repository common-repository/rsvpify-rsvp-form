<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.rsvpify.com
 * @since      1.0.0
 *
 * @package    Rsvpify_Embedd
 * @subpackage Rsvpify_Embedd/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rsvpify_Embedd
 * @subpackage Rsvpify_Embedd/includes
 * @author     Marek Dobrenko <mdobrenko1@gmail.com>
 */
class Rsvpify_Embedd_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rsvpify-embedd',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
