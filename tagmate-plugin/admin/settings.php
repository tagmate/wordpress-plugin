<?php

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'TGM_TLD', 'tagmate.io' );

/**
 * Admin Settings
 *
 * Refctoring note: use add_settings_section() and add_settings_field() 
 */
function tgm_add_settings() {
   add_option( 'tgm_option_platform_id' );
   register_setting( 'tgm_options_group', 'tgm_option_platform_id', 'tgm_is_valid_platform_id' );

   add_option( 'tgm_option_user_id' );
   register_setting( 'tgm_options_group', 'tgm_option_user_id', 'tgm_is_valid_user_id' );

   add_option( 'tgm_option_tag_location' );
   register_setting( 'tgm_options_group', 'tgm_option_tag_location', 'tgm_is_valid_tag_location' );

   add_option( 'tgm_tag_status' );
   register_setting( 'tgm_options_group', 'tgm_tag_status', 'tgm_is_valid_tag_status' );
}
add_action('admin_init', 'tgm_add_settings');


/**
 * Admin Menu and Page
 */
function tgm_add_options_page() {
   add_options_page('Code Sippet Settings - tagmate.io', 'Tagmate', 'manage_options', 'tm', 'tgm_options_page');
}
add_action('admin_menu', 'tgm_add_options_page');


/**
 * Admin Page Content
 *
 * Refactoring note: use do_settings_sections()
 */

function tgm_options_page()
{

?>

<style type="text/css">
  #brand-logo{
    height: 30px;
    margin: 15px 0 15px 0;
  }
  input:invalid, input:focus:invalid {
      border-color: #FBBD0E;
      box-shadow: 0 0 0 1px #FBBD0E;
  }
</style>

<div class="wrap">
  <img src="<?php echo TGM_PLUGIN_URL ?>/assets/img/tagmate-logo.png" id="brand-logo" alt="tagmate logo" />
  <hr>
  <h1 class="title"><?php _e( 'Code Snippet Settings' ) ?></h1>

  <form method="post" action="options.php">
    <?php settings_fields( 'tgm_options_group' ); ?>
    <?php // do_settings_sections(); // add during admin refactoring ?>

    <table class="form-table" role="presentation">
    <tbody>
      <tr>
        <th scope="row"><label for="tgm_option_platform_id"><?php _e( 'Platform ID' ) ?></label></th>
        <td>
          <input type="text" id="tgm_option_platform_id" name="tgm_option_platform_id" value="<?php echo sanitize_key( get_option('tgm_option_platform_id') ) ?>" class="regular-text" placeholder="<?php _e( 'Paste your Platform ID' ) ?>" pattern="<?php echo substr( TGM_PLATFOM_ID_REGEX, 1, -1 ) ?>" title="<?php _e( 'gtm- followed by up to five numbers and alphabet characters' ) ?>" >
            <p class="description" id="tagline-description"><?php _e( 'Please copy-paste your "Platform ID" from your setup instructions page. <br> Correct format example: ') ?> <kbd>tgm-4d3m0</kbd>.</p>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="tgm_option_platform_idx"><?php _e( 'User ID' ) ?></label></th>
        <td>
          <input type="text" id="tgm_option_user_id" name="tgm_option_user_id" value="<?php echo sanitize_key( get_option('tgm_option_user_id') ) ?>" class="regular-text" placeholder="<?php _e( 'Paste your User ID' ) ?>" pattern="<?php echo substr( TGM_USER_ID_REGEX, 1, -1 ) ?>" title="<?php _e( 'numbers, alphabet, hyphen-minus, underscore' ) ?>">
          <p class="description" id="tagline-description"><?php _e( 'Please copy-paste your "User ID" and <strong>if you were provided one</strong>, otherwise leave it blank.<br> Correct format examples: ') ?> <kbd>kfd2_jm6s-8f31f</kbd>, <kbd>3le3t</kbd>, <kbd>42</kbd>.</p>
        </td>
      </tr>

      <tr>
        <th scope="row"><label for="tag_location"><?php _e( 'Loading Priority (location)' ) ?></label></th>
        <td>
          <?php
          $tag_location_options = array_map( 'esc_attr', get_option( 'tgm_option_tag_location' ) );
          ?>
          <select name='tgm_option_tag_location[tmg_select_location]'>
            <option value='head' <?php selected( $tag_location_options['tmg_select_location'], 'head' ); ?>><?php _e( 'High (head)' ) ?></option>
            <option value='footer' <?php selected( $tag_location_options['tmg_select_location'], 'footer' ); ?>><?php _e( 'Low (footer)' ) ?></option>
          </select>

          <p class="description" id="tagline-description"><?php _e( 'Chose where you want to place the code snippet. Important services like Analytics tools should be placed on the `head`<br> and services like chat widgets are placed on the `footer`.') ?></p>
        </td>
      </tr>

      <tr>
        <th scope="row"><?php _e( 'Code Snippet Status' ) ?></th>
        <td>
          <fieldset>
            <p>
              <?php 
                $tag_status_options = get_option( 'tgm_tag_status' );
                $tag_status_options = ( empty( $tag_status_options ) ) ? 'enabled' : $tag_status_options;
              ?>
              <label><input type="radio" name="tgm_tag_status[option_three]" value="enabled"<?php checked( $tag_status_options['option_three'], 'enabled' ); ?> /> <?php _e( 'Enabled' ) ?></label><br>
              <label><input type="radio" name="tgm_tag_status[option_three]" value="disabled"<?php checked( $tag_status_options['option_three'], 'disabled' ); ?> /> <?php _e( 'Disabled' ) ?></label>
            </p>
            <p class="description" id="tagline-description"><?php _e( 'Chose if you want to enable or disable your code snippet.') ?></p>
        </fieldset>
        </td>
      </tr>
    </tbody>
    </table>

    <?php  submit_button(); ?>

  </form>

  <hr>
  <p><a href="https://<?php echo TGM_TLD  ?>/#faq" target="_blank"><?php _e( 'FAQ' ) ?></a> - <a href="mailto:hello@<?php echo TGM_TLD  ?>" target="_blank"><?php _e( 'Need help?' ) ?></a> - <a href="https://<?php echo TGM_TLD  ?>/?ref=wp-tgm" target="_blank"><?php echo TGM_TLD  ?></a> <?php _e( 'Plugin Version' ); echo " " . TGM_VERSION ?></p>
  <hr>

</div>

<?php

}

