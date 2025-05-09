<?php

/**
 * Fired during plugin activation
 *
 * @link       https://aquelando.info
 * @since      1.0.0
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rge_Forms
 * @subpackage Rge_Forms/includes
 * @author     Marcos Chavarría Teijeiro <chavarria1991@gmail.com>
 */
class Rge_Forms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::_create_contact_form_table();
		self::_create_subscription_form_table();
	}

	private static function _create_contact_form_table () {
		global $wpdb;

		$table_name = $wpdb->prefix . "aqd_form_contact";
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				nome varchar(55) NOT NULL,
				telefono varchar(55),
				email varchar(55) NOT NULL,
				tema varchar(100) NOT NULL,
				mensaxe varchar(300) NOT NULL,
				tempo varchar(20) NOT NULL,
				PRIMARY KEY id (id)
		) $charset_collate;";

		if ( ! function_exists('dbDelta') ) {
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		dbDelta( $sql );
	}

	private static function _create_subscription_form_table () {
		global $wpdb;

		$table_name = $wpdb->prefix . "rge_subscription";
 
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				nome varchar(55) NOT NULL,
				email varchar(55) NOT NULL,
        datos varchar(1000),
				tempo varchar(20),
        activa boolean DEFAULT FALSE, 
				PRIMARY KEY id (id)
		) $charset_collate;";

		if ( ! function_exists('dbDelta') ) {
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		dbDelta( $sql );
	}

}
