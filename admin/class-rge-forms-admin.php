<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://aquelando.info
 * @since      1.0.0
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/admin
 * @author     Marcos Chavarría Teijeiro <chavarria1991@gmail.com>
 */
class Rge_Forms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rge-forms-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rge-forms-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function render_contact_submissions() {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-contact-admin.php";
	}

	public function render_subscription_submissions() {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-subscription-admin.php";
	}

	public function render_main_page () {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-main-admin.php";
	}

	public function render_settings_desecription () {
		?>
		<p>Settings for RGE Forms</p>
		<?php
	}

	public function render_email_setting_input () {
		$email = get_option('rge_forms_email');
		?>
			<input id="rge_forms_email" name="rge_forms_email" type="email" value="<?php echo $email; ?>"/>
		<?php
	}

	public function add_admin_pages () {

		add_menu_page(
			__("RGE Forms"),
			__("RGE Forms", "rge-forms"),
			'manage_options',
			'rge-forms-page',
			array($this, 'render_main_page')
		);

		add_submenu_page(
			'rge-forms-page',
			__("Contact Form", "rge-forms"),
			__("Contact Form", "rge-forms"),
			'manage_options',
			'rge-contact-form',
			array($this, 'render_contact_submissions')
		);

		add_submenu_page(
			'rge-forms-page',
			__("Subscription Form", "rge-forms"),
			__("Subscription Form", "rge-forms"),
			'manage_options',
			'rge-subscription-form',
			array($this, 'render_subscription_submissions')
		);

	}

	public function register_and_build_fields() {

		add_settings_section(
			'rge-forms-settings-section',// ID used to identify this section and with which to register options
			'', // Title to be displayed on the administration page
			array( $this, 'render_settings_desecription' ), // Callback used to render the description of the section
			'rge-forms-page' // Page on which to add this section of options
		);

		add_settings_field(
			'rge_forms_email',
			'Email',
			array( $this, 'render_email_setting_input' ),
			'rge-forms-page',
			'rge-forms-settings-section',
		);

		register_setting(
			'rge-forms-page',
			'rge_forms_email'
		);

	}

}
