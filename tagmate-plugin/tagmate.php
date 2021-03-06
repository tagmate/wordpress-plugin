<?php
/*
   Plugin Name: tagmate.io — code snippet installer
   Plugin URI: https://tagmate.io
   description: tagmate.io helps you easily install third-party services code snippets on your website.
   Version: 1.0.0
   Requires at least: 3.9
   Tested up to: 5.5
   Author: Hicham Abdelkaoui (tagmate.io)
   Author URI: https://growthloops.xyz
   License:GPLv2 or later

   Copyright Hicham Abdelkaoui (hicham@tagmate.io), inspired by Thomas Geiger's Google Tag Manager for WordPress (https://wordpress.org/plugins/duracelltomi-google-tag-manager)

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


// Plugin
define( 'TGM_VERSION',              '1.0.0' );
define( 'TGM_PLUGIN_PATH',          plugin_dir_path( __FILE__ ) );
define( 'TGM_PLUGIN_URL',           plugin_dir_url( __FILE__ ) );

// Default domains and other attributes
define( 'TGM_TLD',                  'tagmate.io' );
define( 'TGM_CDN_DOMAIN',           'cdn.tagmate.io' );
define( 'TGM_TAG_CSS_ID',           'tgm-js-tag' );
define( 'TGM_TAG_ATTRIBUTE',        'tgm-data' );
define( 'TGM_JS_FILE',              'tgm.js' );

// Validation patterns
define( 'TGM_PLATFOM_ID_REGEX',     '/^tgm-[0-9a-z]{5}$/' ); // e.g. tgm-4d3m0
define( 'TGM_USER_ID_REGEX',        '/^(?!.*(-|_){2})[0-9A-Za-z-_]{1,33}$/' ); // 1-33 key because each SaaS platform uses different specs
define( 'TGM_TAG_LOCATION_REGEX',   '/^(head|footer)$/' );
define( 'TGM_TAG_STATUS_REGEX',     '/^(enabled|disabled)$/' );


/**
 * Initialize the plugin
 */

function tgm_init() {
  require_once TGM_PLUGIN_PATH . '/helpers/validation.php';

  if ( is_admin() ) {
    require_once TGM_PLUGIN_PATH . '/admin/settings.php';
  } else {
    require_once TGM_PLUGIN_PATH . '/public/front-end.php';
  }
}
add_action( 'plugins_loaded', 'tgm_init' );

