<?php

trait PrimaryNav {
	static function __pnInitialize($obj) {
		$obj->helper('primary_nav');
	}

	/**
	 * Get main navigation. This function checks for the existence of the
	 * MarkupSimpleNavigation module before rendering a menu:
	 * https://github.com/somatonic/MarkupSimpleNavigation#markupsimplenavigation-116
	 *
	 * @since Theme_Name 1.0
	 */
	function primary_nav($options = array()) {
		$options = array_merge(array(
			'current_class' => 'menu__item_-current',
			'parent_class' => 'menu__item_-current-parent',
			'outer_tpl' => '<ul class="menu_-primary">||</ul>',
			'inner_tpl' => '<ul class="menu menu__sub">||</ul>',
			'selector' => 'template!=rss',
			'show_root' => true,
			'list_field_class' => 'menu__item menu__item_-primary',
			'item_tpl' => '<a href="{nav_url|url}">{title|band_title}</a>'
		), $options);

		$modules = wire('modules');

		if ($modules->isInstalled('MarkupSimpleNavigation')) {
			$treeMenu = $modules->get('MarkupSimpleNavigation');
		} else {
			trigger_error("MarkupSimpleNavigation must be added as a module to use " . __FUNCTION__ . "()", E_USER_ERROR);
			return false;
		}

		return $treeMenu->render($options);
	}
}
