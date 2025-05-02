<?php


if(!class_exists('WP_List_Table')){
  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-list-table.php';
}

class RGE_Contact_Form_Table extends WP_List_Table {

    const ITEMS_PER_PAGE = 8;

    public function __construct() {
       parent::__construct( array(
        'singular'=> 'wp_list_contact_submission',
        'plural' =>  'wp_list_contact_submissions',
        'ajax'   =>  false
       ) );
    }

    protected function get_bulk_actions() {
      return array(
        'delete'    => __('Delete', 'rge-forms')
       );
    }

    private static function delete_by_id ($id) {
      global $wpdb;

      $table_name = $wpdb->prefix . "aqd_form_contact";

      $wpdb->delete($table_name, array("id" => $id));
    }

    protected function process_bulk_action() {
      if( 'delete' !== $this->current_action() ) {
        return;
      }

      if (is_array(($_GET['id']))) {
        foreach($_GET['id'] as $id) {
            $this->delete_by_id($id);
        }
        return;
      }

      $this->delete_by_id($_GET['id']);
    }

    public function get_columns() {
      return $columns= array(
         'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
         "tempo"     => _("Time", 'rge-forms'),
         "nome"      => _("Name", 'rge-forms'),
         "telefono"  => _("Phone", 'rge-forms'),
         "email"     => _("Email", 'rge-forms'),
         "tema"      => _("Subject", 'rge-forms'),
         "mensaxe"   => _("Message", 'rge-forms')
      );
    }

    public function prepare_items() {
      global $wpdb; //This is used only if making any database queries

      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();
      $this->_column_headers = array($columns, $hidden, $sortable);

      $this->process_bulk_action();

      $table_name = $wpdb->prefix . "aqd_form_contact";
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

    function column_mensaxe($item) {
      return substr($item->mensaxe, 0, 10) . '...' . '<a href="javascript:rge_app.display_contact_message(' . $item->id .')">' . __('View more', 'rge-forms') . '</a>' . '<div class="hidden" id="full-message-'. $item->id . '">'. $item->mensaxe . '</div>';
    }

    function column_nome ($item) {
      $actions = array(
           'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">%s</a>', $_REQUEST['page'], 'delete', $item->id, __('Delete', 'rge-forms')),
       );

       return sprintf('%1$s %2$s', $item->nome, $this->row_actions($actions) );
    }

    function column_default($item, $column_name){
      switch($column_name){
        case "tempo":
        case "telefono":
        case "email":
        case "tema":
          return $item->$column_name;
        default:
          return print_r($item, true); //Show the whole array for troubleshooting purposes
      }
    }

}
