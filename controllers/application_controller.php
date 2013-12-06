<?php

class ApplicationController extends Controller {

	function __construct(&$config, &$page) {
		parent::__construct($config, $page);

		$this->helper(array($this, 'primary_nav'));
	}

  function get_view_vars() {
    $page =& $this->page;

		$vars = array(
			'seo_title' => $page->get_seo_title(),
			'seo_desc' => $page->seo_descr,
			'seo_noindex' => $page->seo_noindex
		);

		if (method_exists($this, 'view_vars')) {
			$vars = array_merge($this->view_vars(), $vars);
		}

		return $vars;
  }

	/**
	 * Get the seo title set on the page, or use a fallback if no seo title is supplied
	 */
	function get_seo_title() {
		$page =& $this->page;
		$pages =& $this->pages;
		$seo_title = '';

		if ($title = $page->seo_title) {
			$seo_title = $title;
		} else {
			$seo_title = $page->title;
			$seo_title .= ' ' . $pages->get('/settings/')->seo_separator;
			$seo_title .= ' ' . $pages->get('/settings/')->seo_title_append;
		}

		return $seo_title;
	}

  // Fallback index
  function index() {
    return $this->render();
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
