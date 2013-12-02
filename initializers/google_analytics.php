<?php
/*------------------------------------*\
	$CONSTANTS
\*------------------------------------*/
define('GA_UACODE', false);

if (file_exists(dirname($config->paths->templates) . '/config-dev.php')) {
	define('PW_LOCAL_DEV', true);
} else {
	define('PW_LOCAL_DEV', false);
}


/**
 * Output Google Analytics code as per:
 * http://mathiasbynens.be/notes/async-analytics-snippet
 *
 * This function first ensures we are not in a dev environment, and then includes
 * the Google Analytics template found in /partials/google-analytics.inc.php
 *
 * @since Theme_Name 1.0
 */
function google_analytics() {
	if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true && GA_UACODE !== false){
		include "./partials/google-analytics.inc.php";
	}

	return false;
}

View::add_helper('google_analytics');



