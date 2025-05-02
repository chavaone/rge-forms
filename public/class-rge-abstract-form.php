<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://aquelando.info
 * @since      1.0.0
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/public
 * @author     Marcos Chavarría Teijeiro <chavarria1991@gmail.com>
 */
abstract class RGE_Abstract_Form {

	protected $plugin_name;

	protected $version;

  protected $shortcode_name;

	public function __construct( $plugin_name, $version, $shortcode_name ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
    $this->shortcode_name = $shortcode_name;

	}

	abstract public function enqueue_styles();

	abstract public function enqueue_scripts();

  abstract protected function check_send($data);

	abstract protected function check_captcha($data);

	abstract protected function store ($data);

  abstract protected function email ($data);

  abstract protected function render_form();

  abstract protected function render_success_message();

  abstract protected function render_error_message();

  public function shortcode() {

    if (! $this->check_send($_POST)) {
      return $this->render_form();
    }

		if (! $this->check_captcha($_POST)) {
			return $this->render_error_message();
		}

    if ($this->store($_POST) && $this->email($_POST)) {
      return $this->render_success_message();
    } else {
      return $this->render_error_message();
    }
  }

  public function register_shortcode () {
    add_shortcode( $this->shortcode_name, array($this, 'shortcode') );
  }

}
