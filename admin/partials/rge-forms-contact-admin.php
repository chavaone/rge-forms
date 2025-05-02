<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://aquelando.info
 * @since      1.0.0
 *
 * @package    Rge_Forms
 * @subpackage Rge_Forms/admin/partials
 */

 if(!class_exists('RGE_Contact_Form_Table')){
   require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class-contact-form-submission-table.php';
 }

 $wp_list_table = new RGE_Contact_Form_Table();
 $wp_list_table->prepare_items();


?>
<div class="wrap">
  <h1 class="wp-heading-inline"><?php _e("Contact Form Submissions", "rge-forms");?></h1>
  <hr class="wp-header-end">
    <?php
      $wp_list_table->display();
    ?>
  <section class="full_message">
    <h5>Mensaxe</h5>
    <div id="message_display"></div>
  </section>
</div>
