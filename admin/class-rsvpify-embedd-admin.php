<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.rsvpify.com
 * @since      1.1.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Marek Dobrenko <mdobrenko1@gmail.com>
 */
add_action('wp_ajax_processAjax', array('Rsvpify_Embedd_Admin','processAjax'));
add_action('wp_ajax_removeEntry', array('Rsvpify_Embedd_Admin','removeEntry'));

class Rsvpify_Embedd_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.1.0
     *
     * @var string The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.1.0
     *
     * @var string The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.1.0
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $GLOBALS['current_event_id'] = array();

        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix . "embed_rsvpify_plugin";
        $result_events = $wpdb->get_results($query, OBJECT);

        foreach ($result_events as $key => $value) {
            $var = $value->subdomain . ",". $value->event_id . "," .  $value->https_enabled;
            array_push($GLOBALS['current_event_id'], $var);
            add_shortcode($value->subdomain, array($this, 'getEmbed'));
        }

        add_action('plugins_loaded', array($this, 'plugin_update'));
        global $shortcode_tags;
    }

    function plugin_update() {
        if (!get_site_option('plugin_version')) { 
            $this->plugin_updates();
        }
    }

    function plugin_updates() {
        global $wpdb, $plugin_version;

        $wpdb->query(
            "ALTER TABLE `{$wpdb->prefix}embed_rsvpify_plugin`
             ADD COLUMN `https_enabled` SMALLINT(6) NOT NULL");
        add_site_option('plugin_version', '1.2.0');
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.1.0
     */
    public function enqueue_styles()
    {

        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rsvpify_Embedd_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rsvpify_Embedd_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style('bootstrap-switch', plugin_dir_url(__FILE__).'css/bootstrap-switch.min.css', array(), $this->version, 'all');
        
    }


    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.1.0
     */
    public function enqueue_scripts()
    {

        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rsvpify_Embedd_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rsvpify_Embedd_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('bootstrap_js', plugin_dir_url(__FILE__).'js/bootstrap.min.js', array(), $this->version, false);
        wp_enqueue_script('bootstrap_switch_js', plugin_dir_url(__FILE__).'js/bootstrap-switch.min.js', array(), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/rsvpify-embedd-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'myAjax', array( 'ajaxurl' => admin_url('admin-ajax.php')));

    }
/**
 * Register the administration menu for this plugin into the WordPress Dashboard menu.
 *
 * @since    1.1.0
 */
    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_options_page('RSVPify Settings', 'RSVPify.', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
    }
    
    public static function processAjax()
    {
        
        global $wpdb;
        $event_data = $_POST['obj'];

        $event_title = $event_data[0];
        $event_subdomain = $event_data[1];
        $event_id = $event_data[3];
        $https_enabled = $_POST['toggle_https'];

        $query = "SELECT * FROM " . $wpdb->prefix . "embed_rsvpify_plugin". " WHERE subdomain = '{$event_subdomain}'";
        $result_events = $wpdb->get_results($query, ARRAY_A);
       
        if (sizeof($result_events) > 0) {
            echo "duplicate";
        } else {
            $results = $wpdb->insert($wpdb->prefix .'embed_rsvpify_plugin', array(
                "event_name" => $event_title, 
                "subdomain" => $event_subdomain,
                "event_id" => $event_id,
                "https_enabled" => $https_enabled));
            echo json_encode($_POST['obj']);
        }
        die();
    }

    public static function getEmbed($atts, $content, $tag)
    {
        $event_id = '';
        foreach ($GLOBALS['current_event_id'] as $value) {
            $pieces = explode(",", $value);
            if ($pieces[0] == $tag) 
            {
                $event_id = $pieces[1];
                $event_http = $pieces[2];
                break;
            }
        }

        $str = "<script type='text/javascript' src='http://app.rsvpify.com/embed/" . $event_id . "'></script><script type='text/javascript' src='http://app.rsvpify.com/js/iframeResizer.min.js'></script><script type='text/javascript'>iFrameResize({autoResize: true,heightCalculationMethod: 'max',enablePublicMethods: true}, '#RSVPifyIFrame');</script>";

        if($event_http == 1) {
            $str = "<script type='text/javascript' src='https://app.rsvpify.com/embed/" . $event_id . "'></script><script type='text/javascript' src='https://app.rsvpify.com/js/iframeResizer.min.js'></script><script type='text/javascript'>iFrameResize({autoResize: true,heightCalculationMethod: 'max',enablePublicMethods: true}, '#RSVPifyIFrame');</script>";
        }
        
        return $str;
    }

    public static function removeEntry()
    {
        global $wpdb;
        $id = $_POST['id'];
        $results = $wpdb->delete($wpdb->prefix .'embed_rsvpify_plugin', array("subdomain"=>$id));
        die();
    }

/**
 * Add settings action link to the plugins page.
 *
 * @since    1.1.0
 */
    public function add_action_links($links)
    {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="'.admin_url('options-general.php?page='.$this->plugin_name).'">'.__('Settings', $this->plugin_name).'</a>',
            );

        return array_merge($settings_link, $links);
    }

/**
 * Render the settings page for this plugin.
 *
 * @since    1.1.0
 */
    public function display_plugin_setup_page()
    {
        include_once 'partials/rsvpify-embedd-admin-display.php';
    }
}
