<?php

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


/**
 * Validate Platform ID
 */

function tgm_is_valid_platform_id( string $platform_id ) {


  if ( !empty( $platform_id ) ) {

    if( !tgm_matches_pattern( TGM_PLATFOM_ID_REGEX, $platform_id ) ){
      $type = 'error';
      $message = __( 'Unvalid "Platform ID". Please double check your entry and try again.' );
      add_settings_error('tgm_options_group', 'tgm_option_platform_id', $message, $type);
      
      $platform_id = sanitize_key( get_option('tgm_option_platform_id') );
    }
    else{
      $js_file_url  = "https://" . TGM_CDN_DOMAIN . "/" . $platform_id . "/" . TGM_JS_FILE;
      $is_valid_js_file_url = tgm_is_valid_url( $js_file_url );
      if( !$is_valid_js_file_url ) {
        $type = 'error';
        $message = __( 'This "Platform ID" does not exist. Please make sure your entered the right information.' );
        add_settings_error('tgm_options_group', 'tgm_option_platform_id', $message, $type);
        
        $platform_id = sanitize_key( get_option('tgm_option_platform_id') );
      }
      else if ( $is_valid_js_file_url === 'error' ) { // http wp_error
        $type = 'error';
        $message = __( '"Platform ID" validation via http request failed. Please make sure that your server can perfom http requests to "' . TGM_CDN_DOMAIN . '"' );
        add_settings_error('tgm_options_group', 'tgm_option_platform_id', $message, $type);
        
        $platform_id = sanitize_key( get_option('tgm_option_platform_id') );
      }
    }
  }
  else{
    $type = 'error';
    $message = __( 'Your "Platform ID" is required!' );
    add_settings_error('tgm_options_group', 'tgm_option_platform_id', $message, $type);
    
    $platform_id = sanitize_key( get_option('tgm_option_platform_id') );
  }

  return $platform_id;
}

/**
 * Validate User ID
 */

function tgm_is_valid_user_id( string $user_id ) {

  if ( !empty( $user_id ) ) {

    if( !tgm_matches_pattern( TGM_USER_ID_REGEX, $user_id ) ){
      $type = 'error';
      $message = __( 'Unvalid "User ID". Please double check your entry and try again.' );
      add_settings_error('tgm_options_group', 'tgm_option_user_id', $message, $type);
      
      $user_id = sanitize_key( get_option('tgm_option_user_id') );
    }
  }

  return $user_id;
}


/**
 * Validate URL HTTP status
 */

function tgm_is_valid_url( string $url ) {

  $is_valid = false;
  $retry = 2;

  for ( $i = 0; $i <= $retry; $i++) { 

    $http_headers = wp_remote_head( $url );
    if ( empty( $http_headers->errors ) ) {
      if ($http_headers["response"]["code"] === 200) {
       $is_valid = true; 
       break;
      }
    }
    else{
      $is_valid = 'error'; 
      break;
    }

  }
  return $is_valid;
}


/**
 * Validate Tag Location Options
 */

function tgm_is_valid_tag_location( array $tag_location ) {

  // In case someone adds an empty/foreign option via the DOM, so no error messages displayed
  if ( empty( $tag_location ) ) {
    $tag_location = array_map( 'esc_attr', get_option( 'tgm_option_tag_location' ) );
  }
  else{

    if ( !tgm_matches_pattern( TGM_TAG_LOCATION_REGEX, array_values( $tag_location )[0] ) ) {
      $tag_location = array_map( 'esc_attr', get_option( 'tgm_option_tag_location' ) );
    }
  }

  return $tag_location;
}

/**
 * Validate Tag Location Options
 */

function tgm_is_valid_tag_status( array $tag_status ) {
  
  $tag_status_value = array_values( $tag_status )[0];

  if ( empty( $tag_status ) ) {
    $tag_status = array_map( 'esc_attr', get_option( 'tgm_option_tag_status' ) );
  }
  else{

    if ( !tgm_matches_pattern( TGM_TAG_STATUS_REGEX, $tag_status_value ) ) {
      $tag_status = array_map( 'esc_attr', get_option( 'tgm_option_tag_status' ) );
    }
  }

  return $tag_status;
}


/**
 * Matches Pattern
 */

function tgm_matches_pattern( string $pattern, string $string ) {

  $matches = false;

  preg_match( $pattern, $string , $matches, PREG_OFFSET_CAPTURE, 0);

  if ( !empty( $matches ) ){
    $matches = true;
  }

  return $matches;
}
