<?php

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'TGM_CDN_DOMAIN',      'cdn.tagmate.io' );
define( 'TGM_TAG_CSS_ID',      'tgm-js-tag' );
define( 'TGM_TAG_ATTRIBUTE',   'tgm-data' );
define( 'TGM_JS_FILE',         'tgm.js' );

/**
 * Print JS asset tag after validatio and sanitization
 */

function tgm_print_tag(){

	$is_printed = false;

	$platform_id = sanitize_key( get_option('tgm_option_platform_id') );
	$user_id = esc_attr( get_option( 'tgm_option_user_id' ) );

	if ( tgm_is_valid_platform_id( $platform_id ) ) {
		$js_url  = "//" . TGM_CDN_DOMAIN . "/" . $platform_id . "/" . TGM_JS_FILE;

		$js_tag  = "<script id='" . esc_attr( TGM_TAG_CSS_ID ) . "' " . esc_attr( TGM_TAG_ATTRIBUTE ) . "='";

		if ( tgm_is_valid_user_id( $user_id) ) { 
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
 * Refactorign ntoe: thing of cleaner way to handle this!
 */

$tgm_tag_status = array_map( 'esc_attr', get_option( 'tgm_tag_status' ) );
if ( !empty( $tgm_tag_status ) && $tgm_tag_status[ array_key_first( $tgm_tag_status ) ] !== 'disabled' ) {

	$tgm_option_tag_location = array_map( 'esc_attr', get_option( 'tgm_option_tag_location' ) );

	if ( in_array( 'footer', $tgm_option_tag_location, false ) ) { 
		add_action('wp_footer', 'tgm_print_tag');
	}
	else{
		add_action('wp_head', 'tgm_print_tag');
	}
}

