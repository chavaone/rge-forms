<?php



/**
 *
 */
class RGE_Form_Contact extends RGE_Abstract_Form
{

  public function __construct( $plugin_name, $version ) {

    parent::__construct($plugin_name, $version, "rge_form_contacto");

  }

  public function enqueue_styles() {
    wp_register_style( "rge-contact-form", plugin_dir_url( __FILE__ ) . 'css/contact-form.css', array(), $this->version, 'all' );
  }

  public function enqueue_scripts() {}

  protected function store ($data) {
    global $wpdb;

    $table_name = $wpdb->prefix . "aqd_form_contact";

    $table_data = array(
      "nome"     => sanitize_text_field($_POST["rge-nome"]),
      "telefono" => sanitize_text_field($_POST["rge-telefono"]),
      "email"    => sanitize_email($_POST["rge-email"]),
      "tema"     => sanitize_text_field($_POST["rge-asunto"]),
      "mensaxe"  => esc_textarea( $_POST["rge-mensaxe"]),
      "tempo"    => date("Y-m-d H:i:s")
    );

    $format = array('%s','%s', '%s', '%s', '%s');

    return $wpdb->insert($table_name, $table_data, $format);
  }

  protected function email ($data) {

    //GET DATA
    $nome     = sanitize_text_field($_POST["rge-nome"]);
    $telefono = sanitize_text_field($_POST["rge-telefono"]);
    $email    = sanitize_email($_POST["rge-email"]);
    $tema     = sanitize_text_field($_POST["rge-asunto"]);
    $mensaxe  = esc_textarea( $_POST["rge-mensaxe"]);
    $tempo    = date("Y-m-d H:i:s");

    $to = array(
      get_option( 'admin_email' ),
      get_option('rge_forms_email')
    );
    $subject = "Formulario de contacto: " . $tema;
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="gl" dir="ltr">
      <head>
        <meta charset="utf-8">
        <title></title>
      </head>
      <body>
        <article>
          <header>
            <h3>Formulario de contacto</h3>
          </header>
          <main>
            <h4>Datos:</h4>
            <dl>
              <dt>Nome</dt>
              <dd><?php echo $nome; ?></dd>
              <dt>Email</dt>
              <dd><?php echo $email; ?></dd>
              <?php if ($telefono): ?>
                <dt>Teléfono</dt>
                <dd><?php echo $telefono; ?></dd>
              <?php endif; ?>
              <dt>Hora</dt>
              <dd><?php echo $tempo; ?></dd>
              <dt>Asunto</dt>
              <dd><?php echo $tema; ?></dd>
            </dl>
            <h4>Mensaxe</h4>
            <div class="">
              <?php echo $mensaxe; ?>
            </div>
          </main>
        </article>
      </body>
    </html>
    <?php
    $message = ob_get_clean();

		return wp_mail( $to, $subject, $message, $headers);
  }

  protected function render_form() {
    ob_start();
    wp_enqueue_style("rge-contact-form");
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-contacto.php";
    return ob_get_clean();
  }

  protected function render_success_message() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-contacto-success.php";
    return ob_get_clean();
  }

  protected function render_error_message() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-contacto-error.php";
    return ob_get_clean();
  }

  protected function check_send($data) {
    return isset( $data['rge-enviar'] );
  }

  protected function check_captcha($data) {
    return $data['rge-captcha'] == "cinco" ||
           $data['rge-captcha'] == "Cinco" ||
           $data['rge-captcha'] == "5";
  }

}
