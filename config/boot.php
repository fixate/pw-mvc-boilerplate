<?php
/*------------------------------------*\
	Load environment code
\*------------------------------------*/
require TEMPLATE_DIR.'/config/environment.php';

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

require_once TEMPLATE_DIR.'core/all.php';


/*------------------------------------*\
  Intializers
\*------------------------------------*/

\fixate\Php::require_all(TEMPLATE_DIR.'initializers/');


/*------------------------------------*\
  $CONTROLLERS
\*------------------------------------*/
/**
 * Site-wide controllers which hold logic, and helpers for access to fields defined
 * in templates.
 *
 * A global controller is available to all templates. Template-specific controllers
 * may override variables defined in the global controller.
 *
 * Template-specific controllers are only loaded on pages using that particular
 * template.
 */

/**
 * Load the controller associated with the current template if it exists
 */

require_once "{$config->paths->templates}/controllers/application_controller.php";
Controller::set_fallback_controller('ApplicationController');
Controller::run($config, $page);
