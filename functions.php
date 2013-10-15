<?php
/**
 * Functions and template helpers
 *
 * @since Theme_Name 1.0
 */

define('GA_UACODE', false);

if (file_exists(dirname(__FILE__) . '/../config.dev.php')) {
	define('PW_LOCAL_DEV', true);
} else {
  define('PW_LOCAL_DEV', false);
}

