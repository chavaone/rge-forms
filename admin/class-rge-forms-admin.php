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

  public function render_wellcome_page() {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-wellcome-page.php";
  }

	public function render_contact_submissions() {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-contact-admin.php";
	}

	public function render_subscription_submissions() {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-subscription-admin.php";
	}

	public function render_settings_page () {
		include plugin_dir_path( __FILE__ ) . "partials/rge-forms-settings-admin.php";
	}

	public function render_settings_description () {
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

 public function procesar_csv_suscriptores($archivo, $activo) {
    global $wpdb;
    $table_name = $wpdb->prefix . "rge_subscription";

    if (($handle = fopen($archivo['tmp_name'], 'r')) !== FALSE) {
      $fila = 0;
      $insertados = 0;
      $omitidos = [];

      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $fila++;

        // Saltar cabecera si empieza por "nombre"
        if ($fila == 1 && strtolower(trim($data[0])) == 'nombre') {
          continue;
        }

        $nombre = sanitize_text_field($data[0]);
        $email = sanitize_email($data[1]);

        if (!empty($nombre) && is_email($email)) {
          // Comprobar si el email ya existe
          $existe = $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email)
          );

          if ($existe) {
            $omitidos[] = [
              'fila' => $fila,
              'nombre' => $nombre,
              'email' => $email
            ];
            continue;
          }

          $wpdb->insert(
            $table_name,
            [
              'nome'   => $nombre,
              'email'  => $email,
              'datos'  => '',
              'tempo'  => current_time('mysql'),
              'activa' => $activo,
            ],
            ['%s', '%s', '%s', '%s', '%d']
          );
          $insertados++;
        }
      }
      fclose($handle);

      // Mensaje de éxito
      echo '<div class="notice notice-success"><p>Se importaron ' . esc_html($insertados) . ' registros.</p></div>';

      // Mostrar omitidos si los hay
      if (!empty($omitidos)) {
        echo '<div class="notice notice-warning"><p>Se omitieron ' . count($omitidos) . ' registros por email duplicado:</p>';
        echo '<ul>';
        foreach ($omitidos as $om) {
          echo '<li>Fila ' . esc_html($om['fila']) . ': ' . esc_html($om['nombre']) . ' (' . esc_html($om['email']) . ')</li>';
        }
        echo '</ul></div>';
      }
    } else {
      echo '<div class="notice notice-error"><p>No se pudo leer el archivo CSV.</p></div>';
    }
  }


  public function mostrar_pagina_importacion() {
    ?>
    <div class="wrap">
      <h1>Importar Suscriptores</h1>
      <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('importar_csv', 'importar_csv_nonce'); ?>
        <p>
          <label for="csv_file">Archivo CSV (nombre,email):</label><br>
          <input type="file" name="csv_file" accept=".csv" required>
        </p>
        <p>
          <label for="activo">¿Activar los nuevos registros?</label><br>
          <select name="activo">
            <option value="1">Sí</option>
            <option value="0">No</option>
          </select>
        </p>
        <?php submit_button('Importar'); ?>
      </form>
    </div>
    <?php

    if (
      isset($_FILES['csv_file']) &&
      isset($_POST['activo']) &&
      check_admin_referer('importar_csv', 'importar_csv_nonce')
    ) {
      $this->procesar_csv_suscriptores($_FILES['csv_file'], intval($_POST['activo']));
    }
  }

	public function add_admin_pages () {

		add_menu_page(
			"Formularios RGE",
			"Formularios RGE",
			'manage_options',
			'rge-forms-page',
			array($this, 'render_wellcome_page'),
      'dashicons-forms'
		);

    add_submenu_page(
			'rge-forms-page',
			"Formulario Contacto",
			"Formulario Contacto",
			'manage_options',
			'rge-contact-form',
			array($this, 'render_contact_submissions'),
      10
		);

		add_submenu_page(
			'rge-forms-page',
			"Formulario Suscriptores",
			"Formulario Suscriptores",
			'manage_options',
			'rge-contact-form',
      array($this, 'render_subscription_submissions'),
      11
		);

    add_submenu_page(
    'rge-forms-page',
		'Importar Suscriptores',
		'Importar Suscriptores',
		'manage_options',
		'importar-suscriptores',
    array($this, 'mostrar_pagina_importacion'),
    12
    );

		add_submenu_page(
			'rge-forms-page',
			"Configuración",
			"Configuración",
			'manage_options',
			'rge-forms-settings',
      array($this, 'render_settings_page'),
      13
		);

	}

	public function register_and_build_fields() {

		add_settings_section(
			'rge-forms-settings-section',// ID used to identify this section and with which to register options
			'', // Title to be displayed on the administration page
			array( $this, 'render_settings_description' ), // Callback used to render the description of the section
			'rge-forms-settings' // Page on which to add this section of options
		);

		add_settings_field(
			'rge_forms_email',
			'Email',
			array( $this, 'render_email_setting_input' ),
			'rge-forms-settings',
			'rge-forms-settings-section',
		);

		register_setting(
			'rge-forms-settings',
			'rge_forms_email'
		);

	}

}
