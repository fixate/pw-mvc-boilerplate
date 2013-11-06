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
  $FIELDS
\*------------------------------------*/
$seo_title = $page->get('seo_title|title');
$seo_desc = $page->seo_descr;
$seo_noindex = $page->seo_noindex;

$assets_uri = $config->urls->templates . 'assets';





/*------------------------------------*\
  $FUNCTIONS
\*------------------------------------*/
/**
 * Delegate rendering to the current template's view
 *
 * This function is called in main.php, and is responsible for outputting anything
 * defined within the view of any template
 *
 * @since Theme_Name 1.0
 */
function render_view($page, $config) {
  if ($page->template) {
    $t = new TemplateFile($config->paths->templates . "views/{$page->template}.inc.php");
    echo $t->render();
  }
}


/**
 * Output Google Analytics code as per:
 * http://mathiasbynens.be/notes/async-analytics-snippet
 *
 * @since Theme_Name 1.0
 */
function get_google_analytics() {
  if (defined('PW_LOCAL_DEV') && PW_LOCAL_DEV !== true && GA_UACODE !== false){
    include "./partials/google-analytics.inc.php";
  }

  return false;
}
