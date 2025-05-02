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
?>

<div class="wrap">
  <h1 class="wp-heading-inline"><?php _e("Subscription Form Submissions", "rge-forms");?></h1>
  <hr class="wp-header-end">

  <form method="POST" action="options.php">
      <?php
          settings_fields( 'rge-forms-page' );
          do_settings_sections( 'rge-forms-page' );
      ?>
      <?php submit_button(); ?>
  </form>
</div>
