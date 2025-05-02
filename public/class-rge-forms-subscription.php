<?php


/**
 *
 */
class RGE_Form_Subscription extends RGE_Abstract_Form
{

  public function __construct( $plugin_name, $version ) {

    parent::__construct($plugin_name, $version, "rge_form_subs");

  }

  public function enqueue_styles() {
    wp_register_style( "rge-subscription-form", plugin_dir_url( __FILE__ ) . 'css/subscription-form.css', array(), $this->version, 'all' );
  }

  public function enqueue_scripts() {
    wp_register_script("rge-subscription-form", plugin_dir_url( __FILE__ ) . 'js/subscription-form.js', ['jquery']);

  }

  protected function store ($data) {
    global $wpdb;

		$table_name = $wpdb->prefix . "rge_subscription";

    $nome       = sanitize_text_field($_POST["rge-nome"]);
    $nif        = sanitize_text_field($_POST["rge-nif"]);
    $email      = sanitize_email($_POST["rge-email"]);
    $is_neg     = $_POST["rge-isneg"] == 'on' ? "si" : "non";
    $enderezo   = isset($_POST["rge-enderezo"]) ? sanitize_text_field($_POST["rge-enderezo"]) : "";
    $cp         = isset($_POST["rge-cp"]) ? sanitize_text_field($_POST["rge-cp"]) : "";
    $localidade = isset($_POST["rge-localidade"]) ? sanitize_text_field($_POST["rge-localidade"]) : "";
    $concello   = isset($_POST["rge-concello"]) ? sanitize_text_field($_POST["rge-concello"]) : "";
    $provincia  = isset($_POST["rge-provincia"]) ? sanitize_text_field($_POST["rge-provincia"]) : "";
    $telefono1  = isset($_POST["rge-telefono1"]) ? sanitize_text_field($_POST["rge-telefono1"]) : "";
    $telefono2  = isset($_POST["rge-telefono2"]) ? sanitize_text_field($_POST["rge-telefono2"]) : "";
    $pagoneg    = $_POST["rge-pagamentoneg"] == "on" ? "Mesma que NEG" : "" ;
    $formapago  = isset($_POST["rge-formapagamento"]) ? sanitize_text_field($_POST["rge-formapagamento"]) : "";
    $banco      = isset($_POST["rge-banco"]) ? sanitize_text_field($_POST["rge-banco"]) : "";
    $iban       = isset($_POST["rge-iban"]) ? sanitize_text_field($_POST["rge-iban"]) : "";
    $titular    = isset($_POST["rge-titular"]) ? sanitize_text_field($_POST["rge-titular"]) : "";
    $tempo      = date("Y-m-d H:i:s");
   
    $datos = '{
    "neg": "' . $is_neg . '",
    "nif": "' . $nif . '",
    "enderezo": "' . $enderezo . ' - ' . $cp . ' - ' . $localidade . ' - ' . $concello . ' (' . $provincia . ')",
    "tlf":  "' . $telefono1 . ' / ' . $telefono2 . '",
    "pago": "' . $pagoneg . ' ' . $formapago . ' ' . '(' . $banco . ' - ' . $iban . ' - ' . $titular . ')"
    }';

    $data = array(
      "nome"     => $nome,
      "email"    => $email,
      "datos"    => $datos,
      "tempo"    => date("Y-m-d H:i:s")
    );

    $format = array('%s', '%s', '%s', '%s');

    return $wpdb->insert($table_name, $data, $format);
  }

  protected function email ($data) {
    $nome       = sanitize_text_field($_POST["rge-nome"]);
    $nif        = sanitize_text_field($_POST["rge-nif"]);
    $email      = sanitize_email($_POST["rge-email"]);
    $is_neg     = $_POST["rge-isneg"] == 'on';
    $enderezo   = isset($_POST["rge-enderezo"]) ? sanitize_text_field($_POST["rge-enderezo"]) : "";
    $cp         = isset($_POST["rge-cp"]) ? sanitize_text_field($_POST["rge-cp"]) : "";
    $localidade = isset($_POST["rge-localidade"]) ? sanitize_text_field($_POST["rge-localidade"]) : "";
    $concello   = isset($_POST["rge-concello"]) ? sanitize_text_field($_POST["rge-concello"]) : "";
    $provincia  = isset($_POST["rge-provincia"]) ? sanitize_text_field($_POST["rge-provincia"]) : "";
    $telefono1  = isset($_POST["rge-telefono1"]) ? sanitize_text_field($_POST["rge-telefono1"]) : "";
    $telefono2  = isset($_POST["rge-telefono2"]) ? sanitize_text_field($_POST["rge-telefono2"]) : "";
    $pagoneg    = $_POST["rge-pagamentoneg"] == "on";
    $formapago  = isset($_POST["rge-formapagamento"]) ? sanitize_text_field($_POST["rge-formapagamento"]) : "";
    $banco      = isset($_POST["rge-banco"]) ? sanitize_text_field($_POST["rge-banco"]) : "";
    $iban       = isset($_POST["rge-iban"]) ? sanitize_text_field($_POST["rge-iban"]) : "";
    $titular    = isset($_POST["rge-titular"]) ? sanitize_text_field($_POST["rge-titular"]) : "";
    $tempo      = date("Y-m-d H:i:s");

    //EMAIL RGE e ADMIN WEB
    $to = array(
      get_option( 'admin_email' ),
      get_option('rge_forms_email')
    );
    $subject = "Web RGE - Formulario de subscrición: " . $nome;
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-subscription-email-rge.php";
    $message = ob_get_clean();

    do_action('qm/debug', $message);

		$ret_rge = wp_mail( $to, $subject, $message, $headers );

    //EMAIL Usuario
    $to = array(
      $email
    );
    $subject = "Web RGE - Formulario de subscrición";
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-subscription-email-client.php";
    $message = ob_get_clean();

    do_action('qm/debug', $message);
    
    $ret_client = wp_mail( $to, $subject, $message, $headers );


    return $ret_rge && $ret_client;
  }

  protected function render_form() {
    ob_start();
    wp_enqueue_style("rge-subscription-form");
    wp_enqueue_script("rge-subscription-form");
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-subscription.php";
    return ob_get_clean();
  }

  protected function render_success_message() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-subscription-success";
    return ob_get_clean();
  }

  protected function render_error_message() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . "partials/rge-forms-template-subscription-error.php";
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

  public function filter_issue_visibility_subscriptions($visibility, $issue) {

    if (! class_exists( 'AQDIssue' ) ) {
      return $visibility;
    }

    global $wpdb;

    $table_name = $wpdb->prefix . "rge_subscription";

    if ($visibility == AQDIssue::VISIBILITY_OPENED or
        $visibility == AQDIssue::VISIBILITY_DRAFT
    ) {
      return $visibility;
    }

    $current_user = wp_get_current_user();

    if (! $current_user->exists()) {
      return $visibility;
    }

    $user_email =  $current_user->user_email;

    $count = $wpdb->get_var("SELECT count(s.email)
      FROM $table_name as s
      WHERE s.email = '$user_email'
      AND s.activa = TRUE");

    if ($count > 0) {
      return AQDIssue::VISIBILITY_OPENED;
    }

    return $visibility;

  }


}
