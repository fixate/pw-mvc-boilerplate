<?php

trait PrimaryNav {
	function __pnInitialize() {
		$this->helper('primary_nav');
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
				'current_class' => 'menu__item_-current',
				'outer_tpl' => '<ul class="menu menu_-primary">||</ul>',
				'inner_tpl' => '<ul class="menu menu__sub">||</ul>',
				'show_root' => true,
				'list_field_class' => 'menu__item menu__item_-primary',
				'item_tpl' => '<a href="{nav_url|url}">{title}</a>'
			)
		);
	}
}
