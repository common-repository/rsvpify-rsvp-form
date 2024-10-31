<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.rsvpify.com
 * @since             1.0.0
 * @package           Rsvpify_Embedd
 *
 * @wordpress-plugin
 * Plugin Name:       RSVPify RSVP Form
 * Plugin URI:        www.rsvpify.com
 * Description:       Quickly create a hugely-customizable RSVP form for your wedding or event. Get every detail you need in one seamless RSVP experience.
 * Version:           1.1.0
 * Author:            RSVPify
 * Author URI:        www.rsvpify.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rsvpify-embedd
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rsvpify-embedd-activator.php
 */
function activate_rsvpify_embedd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rsvpify-embedd-activator.php';
	Rsvpify_Embedd_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rsvpify-embedd-deactivator.php
 */
function deactivate_rsvpify_embedd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rsvpify-embedd-deactivator.php';
	Rsvpify_Embedd_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rsvpify_embedd' );
register_deactivation_hook( __FILE__, 'deactivate_rsvpify_embedd' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rsvpify-embedd.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rsvpify_embedd() {

	$plugin = new Rsvpify_Embedd();
	$plugin->run();

}
run_rsvpify_embedd();
