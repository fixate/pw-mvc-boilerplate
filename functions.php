<?php
/**
 * Functions and template helpers
 *
 * @since Theme_Name 1.0
 */

/**
 * Define global constants
 */
if (file_exists(dirname(__FILE__) . '/../config-dev.php')) {
	define('PW_LOCAL_DEV', true);
} else {
  define('PW_LOCAL_DEV', false);
}

define('GA_UACODE', false);


/**
 * Output Google Analytics code as per:
 * http://mathiasbynens.be/notes/async-analytics-snippet
 *
 * @since Theme_Name 1.0
 */
function get_google_analytics() {
  if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true && GA_UACODE !== false){
    include("./partials/google-analytics.inc.php");
  }

  return false;
}
