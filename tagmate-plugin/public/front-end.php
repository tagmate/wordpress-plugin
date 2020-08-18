<?php

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


/**
 * Print JS asset tag after validation and sanitization
 */

function tgm_print_tag(){

	$is_printed = false;

	$platform_id = sanitize_key( get_option('tgm_option_platform_id') );
	$user_id = esc_attr( get_option( 'tgm_option_user_id' ) );

	if ( !empty( $platform_id ) ) {
		$js_url  = "//" . TGM_CDN_DOMAIN . "/" . $platform_id . "/" . TGM_JS_FILE;

		$js_tag   = "<!-- Code Snippet Installer for WordPress by tagmate.io-->";
		$js_tag  .= "<script id='" . esc_attr( TGM_TAG_CSS_ID ) . "' " . esc_attr( TGM_TAG_ATTRIBUTE ) . "='";

		if ( !empty( $user_id ) ) { 
			$js_tag  .= $user_id;
		}

		$js_tag  .= "' type='text/javascript' src='" . $js_url . "'></script>";

    	echo $js_tag;
    	$is_printed = true;
	}

	return $is_printed;
}

/**
 * Handle enabled|disabled status and tag head|footer printing location
 * 
 */

if ( get_option( 'tgm_option_platform_id' ) ) {

	$tgm_option_tag_status =  get_option( 'tgm_option_tag_status' );
	if (  !empty( $tgm_option_tag_status ) && !in_array( 'disabled', $tgm_option_tag_status ) ) {

		$tgm_option_tag_location = get_option( 'tgm_option_tag_location' );	
		if ( in_array(  'footer', $tgm_option_tag_location ) ) { 
			add_action( 'wp_footer', 'tgm_print_tag' );
		}
		else{
			add_action( 'wp_head', 'tgm_print_tag' );
		}
	}
}

