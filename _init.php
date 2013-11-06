<?php
/*------------------------------------*\
  $_INIT.PHP
\*------------------------------------*/
/**
 * This is the global init file included before all template files.
 *
 * Use of this is optional and set via $config->prependTemplateFile in /site/config.php.
 * This file is used to make controllers available to each template. Controllers are
 * used to keep logic out of the templates, and to make available all fields defined
 * in the templates.
 */





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
include "./controllers/globals-controller.php";

if ($page->template) {
  include "./controllers/{$page->template}-controller.php";
}
