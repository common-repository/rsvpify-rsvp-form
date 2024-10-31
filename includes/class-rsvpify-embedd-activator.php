 <?php

/**
 * Fired during plugin activation
 *
 * @link       www.rsvpify.com
 * @since      1.1.0
 *
 * @package    Rsvpify_Embedd
 * @subpackage Rsvpify_Embedd/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.1.0
 * @package    Rsvpify_Embedd
 * @subpackage Rsvpify_Embedd/includes
 * @author     Marek Dobrenko <mdobrenko1@gmail.com>
 */
class Rsvpify_Embedd_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.1.0
     */

    public static function activate()
    {
        global $wpdb;
        $database = $wpdb->prefix . "embed_rsvpify_plugin";

        if ($wpdb->get_var("show tables like '$database'") != $database) {
            $sql = "CREATE TABLE " . $database . "(
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            event_name VARCHAR(255) NOT NULL,
            subdomain VARCHAR(255) NOT NULL,
            event_id mediumint(9) NOT NULL,
            https_enabled VARCHAR(255) NOT NULL,
            UNIQUE KEY id (id)
            );";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta($sql);
        }
    }
}
