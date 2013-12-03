<?php

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
