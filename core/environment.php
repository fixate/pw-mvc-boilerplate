<?php
/*------------------------------------*\
	$CONSTANTS
\*------------------------------------*/
if (file_exists(dirname($config->paths->templates) . '/config-dev.php')) {
  define('PW_LOCAL_DEV', true);
} else {
  define('PW_LOCAL_DEV', false);
}
