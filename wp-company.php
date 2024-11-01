<?php
/**
 * @package   wp_company
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2013 Buooy
 *
 * @wordpress-plugin
 * Plugin Name:       WP Company
 * Plugin URI:        http://buooy.com
 * Description:       WP Company 
 * Version:           1.1.1
 * Author:            Aaron Lee
 * Author URI:        http://buooy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-wp-company.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'WP_Company', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Company', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace WP_Company with the name of the class defined in
 *   `class-wp-company.php`
 */
add_action( 'plugins_loaded', array( 'WP_Company', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-admin.php` with the name of the plugin's admin file
 * - replace WP_Company_Admin with the name of the class defined in
 *   `class-wp-company-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
//if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-wp-company-admin.php' );
	add_action( 'plugins_loaded', array( 'WP_Company_Admin', 'get_instance' ) );

}
