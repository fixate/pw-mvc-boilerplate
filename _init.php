<?php
/*------------------------------------*\
	Load core
\*------------------------------------*/
/**
 * This is the global init file included before all template files.
 *
 * This file is used to make controllers available to each template. Controllers are
 * used to keep logic out of the templates, and to make available all fields defined
 * in the templates.
 */

define('TEMPLATE_DIR', dirname(__FILE__) . '/');

require_once TEMPLATE_DIR.'core/all.php';


/*------------------------------------*\
	Intializers
\*------------------------------------*/

\fixate\Php::require_all(TEMPLATE_DIR.'initializers/');

