<?php


if(!class_exists('WP_List_Table')){
  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-list-table.php';
}

class RGE_Subscription_Form_Table extends WP_List_Table {

    const ITEMS_PER_PAGE = 8;

    public function __construct() {
       parent::__construct( array(
        'singular'=> 'wp_list_subscription_submission', //Singular label
        'plural' =>  'wp_list_subscription_submissions', //plural label, also this well be one of the table css class
        'ajax'   => false //We won't support Ajax for this table
       ) );
    }

    protected function get_bulk_actions() {
      return array(
        'delete'    => "Eliminar", 
        'activar'   => "Activar"
       );
    }

    private static function action_by_id ($action, $id) {
      if ($action == "delete") { self::delete_by_id($id); }
      if ($action == "activar") { self::activar_by_id($id); }
    }

    private static function delete_by_id ($id) {
      global $wpdb;

      $table_name =  $wpdb->prefix . "rge_subscription";

      $wpdb->delete($table_name, array("id" => $id));
    }

    private static function activar_by_id($id) {
      global $wpdb;

      $table_name = $wpdb->prefix . "rge_subscription";

      // Obtener valor actual
      $valor_actual = $wpdb->get_var(
        $wpdb->prepare("SELECT activa FROM $table_name WHERE id = %d", $id)
      );

      if (is_null($valor_actual)) {
        return new WP_Error('no_encontrado', 'No se encontró el registro.');
      }

      // Invertir el valor
      $nuevo_valor = $valor_actual ? 0 : 1;

      // Actualizar en la base de datos
      $wpdb->update(
        $table_name,
        [ 'activa' => $nuevo_valor ],
        [ 'id' => $id ],
        [ '%d' ],
        [ '%d' ]
      );

    }

    protected function process_bulk_action() {
      if( 'delete' !== $this->current_action() && 'activar' !== $this->current_action()) {
        return;
    }

      if (is_array(($_GET['id']))) {
        foreach($_GET['id'] as $id) {
            $this->action_by_id($this->current_action(), $id);
        }
        return;
      }

      $this->action_by_id($this->current_action(), $_GET['id']);
    }

    public function get_columns() {
      return $columns= array(
         'cb'         => '<input type="checkbox" />', //Render a checkbox instead of text
         "tempo"      => "Hora",
         "nome"       => "Nome e apelidos",
         "email"      => "Email",
         "activa"     => "Activa",
         "accions"    => "Accións"
    );

    }

    public function prepare_items() {
      global $wpdb; //This is used only if making any database queries

      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();
      $this->_column_headers = array($columns, $hidden, $sortable);

      $this->process_bulk_action();

      $table_name = $wpdb->prefix . "rge_subscription";
      $query = "SELECT * from $table_name
                ORDER BY id DESC";

      $current_page = $this->get_pagenum();
      $total_items = $wpdb->query($query);


      $this->set_pagination_args( array(
          'total_items' => $total_items,
          'per_page'    => self::ITEMS_PER_PAGE,
          'total_pages' => ceil($total_items/self::ITEMS_PER_PAGE)
      ) );

      $offset = ($current_page-1) * self::ITEMS_PER_PAGE;
      $query .= ' LIMIT ' . (int) $offset. ',' . (int) self::ITEMS_PER_PAGE;

      $this->items = $wpdb->get_results($query);
    }

    function column_cb($item){
      return sprintf(
        '<input type="checkbox" name="%1$s[]" value="%2$s" />',
        /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
        /*$2%s*/ $item->id                //The value of the checkbox should be the record's id
          );
    }

    function column_nome ($item) {
       return sprintf('%1$s', $item->nome);
    }

    function column_email ($item) {
      return sprintf("<a href='mailto:%s'>%s</a>", $item->email, $item->email);
    }

    function column_activa ($item) {
      return $item->activa ? "SI" : "NON";
    }

    function column_accions ($item) {
      $delete =  sprintf('<a href="?page=%s&action=delete&id=%s"><span class="dashicons dashicons-trash"></span>Eliminar</a>', $_REQUEST['page'], $item->id);
      $activar =  sprintf('<a href="?page=%s&action=activar&id=%s">%s</a>', $_REQUEST['page'], $item->id, $item->activa ? "<span class=\"dashicons dashicons-hidden\"></span>Desactivar" : "<span class=\"dashicons dashicons-visibility\"></span>Activar");
      $datos  = sprintf("<div class=\"hidden\" id=\"data-%d\">%s</div><a href=\"javascript:rge_app.display_subscription_data(%d);\"><span class=\"dashicons dashicons-info\"></span>Datos</a>", $item->id, $item->datos, $item->id);

      return $delete . " " . $activar . " " . $datos;

    }
    
    function column_default($item, $column_name){
      switch($column_name){
        case "tempo":
          return $item->$column_name;
        default:
          return print_r($item, true); //Show the whole array for troubleshooting purposes
      }
    }

}
