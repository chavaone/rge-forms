<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://matesetal.gal
 * @since             1.0.0
 * @package           Rge_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       RGE Forms
 * Plugin URI:        https://github.com/chavaone/rge-forms
 * GitHub Plugin URI: https://github.com/chavaone/rge-forms
 * Description:       Plugin simple que añade a funcionalidade de crear formularios de contacto e de subscrición a RGE.
 * Version:           1.0.0
 * Author:            Marcos Chavarría Teijeiro
 * Author URI:        https://matesetal.gal
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rge-forms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RGE_FORMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rge-forms-activator.php
 */
function activate_rge_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rge-forms-activator.php';
	Rge_Forms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rge-forms-deactivator.php
 */
function deactivate_rge_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rge-forms-deactivator.php';
	Rge_Forms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rge_forms' );
register_deactivation_hook( __FILE__, 'deactivate_rge_forms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rge-forms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rge_forms() {

	$plugin = new Rge_Forms();
	$plugin->run();

}
run_rge_forms();
