<?php
/*------------------------------------*\
	LOAD CORE
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
	LOAD ENVIRONMENT
\*------------------------------------*/
require TEMPLATE_DIR.'/config/environment.php';
// Get and initialize the environment
$_GLOBALS['env'] = $env = Environment::get_instance();
$env->set_env(getenv('PW_ENV') || $config->debug ? 'development' : 'production');
// Set user variables
$env->set($environment);
// We dont need user environment from here on
unset($environment);





/*------------------------------------*\
	LOAD MANIFEST
\*------------------------------------*/
if ($env::is_production()) {
	$_GLOBALS['manifest'] = $manifest = Manifest::get_instance();
	$manifest->initialize(TEMPLATE_DIR.'/assets/manifest.json');
}





/*------------------------------------*\
  INTIALIZERS
\*------------------------------------*/
/**
 * Put initialization code for your various modules
 * in the initializers directory.
 */
if (is_dir(TEMPLATE_DIR.'initializers/')){
	\fixate\Php::require_all(TEMPLATE_DIR.'initializers/');
}





/*------------------------------------*\
	CONTROLLERS
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
if (!$config->ajax) {
	require_once "{$config->paths->templates}/controllers/application_controller.php";
	Controller::set_fallback('ApplicationController');
}

Application::init($config, $fields, $input, $page, $pages, $permissions, $roles, $sanitizer, $session, $templates, $user, $users);
Application::run();
