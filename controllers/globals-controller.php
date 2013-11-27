<?php
/**
 * Global Controller
 *
 * Fields and functions that are globally accessible to all templates are defined
 * here. This controller is included in _init.php, and is available to all templates
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
/*------------------------------------*\
  $CONSTANTS
\*------------------------------------*/
define('GA_UACODE', false);

if (file_exists(dirname($config->paths->templates) . '/config-dev.php')) {
  define('PW_LOCAL_DEV', true);
} else {
  define('PW_LOCAL_DEV', false);
}





/*------------------------------------*\
  $VARIABLES
\*------------------------------------*/
$assets_uri = $config->urls->templates . 'assets';





/*------------------------------------*\
  $FIELDS
\*------------------------------------*/
$seo_title = $page->get('seo_title|title');
$seo_desc = $page->seo_descr;
$seo_noindex = $page->seo_noindex;





/*------------------------------------*\
  $FUNCTIONS
\*------------------------------------*/
/**
 * Delegate rendering of a template to its view
 *
 * @since Theme_Name 1.0
 */
function render_view() {
  $page = wire('page');

  if ($page->template) {
    include "./views/{$page->template}.inc.php";
  }
}


/**
 * Get main navigation. This function checks for the existence of the
 * MarkupSimpleNavigation module before rendering a menu:
 * https://github.com/somatonic/MarkupSimpleNavigation#markupsimplenavigation-116
 *
 * @since Theme_Name 1.0
 */
function get_primary_nav() {
  $modules = wire('modules');

  if ($modules->isInstalled('MarkupSimpleNavigation')) {
    $treeMenu = $modules->get('MarkupSimpleNavigation');
  } else {
    trigger_error("Please install MarkupSimpleNavigatin to use " . __FUNCTION__ . "()", E_USER_ERROR);
    return false;
  }

  return $treeMenu->render(
    array(
      'current_class' => 'menu__item--current',
      'outer_tpl' => '<ul class="menu menu--primary">||</ul>',
      'inner_tpl' => '<ul class="menu menu__sub">||</ul>',
      'show_root' => true,
      'list_field_class' => 'menu__item menu__item--primary',
    )
  );
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
function get_google_analytics() {
  if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true && GA_UACODE !== false){
    include "./partials/google-analytics.inc.php";
  }

  return false;
}
