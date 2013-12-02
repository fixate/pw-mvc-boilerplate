<?php

abstract class ApplicationController extends Controller {

	function __construct(&$config, &$page) {
		parent::__construct($config, $page);

		$this->helper(array($this, 'primary_nav'));
	}

  function get_view_vars() {
    $page =& $this->page;

		$vars = array(
			'seo_title' => $page->get('seo_title|title'),
			'seo_desc' => $page->seo_descr,
			'seo_noindex' => $page->seo_noindex
		);

		if (method_exists($this, 'view_vars')) {
			$vars = array_merge($this->view_vars(), $vars);
		}

		return $vars;
  }

  /**
   * Get main navigation. This function checks for the existence of the
   * MarkupSimpleNavigation module before rendering a menu:
   * https://github.com/somatonic/MarkupSimpleNavigation#markupsimplenavigation-116
   *
   * @since Theme_Name 1.0
   */
  function primary_nav() {
    $modules = wire('modules');

    if ($modules->isInstalled('MarkupSimpleNavigation')) {
      $treeMenu = $modules->get('MarkupSimpleNavigation');
    } else {
      trigger_error("MarkupSimpleNavigation must be added as a module to use " . __FUNCTION__ . "()", E_USER_ERROR);
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
}
