<?php

use ProcessWire as PW;

trait MenuFactory
{
  /**
   * __menuInitialize
   *
   * Used to initialize this trait from within a controller
   *
   * @param  $controller - the Controller using this trait
   * @return void
   */
  public static function __menuInitialize($controller)
  {
    $controller->helper('primary_menu');
  }

  public function primary_menu($options = [])
  {
    return $this->__render(array_merge(array(
      'outer_tpl' => '<ul class="menu--primary js-menu-primary">||</ul>',
    ), $options));
  }

  /**
   * __get_menu_instance
   *
   * Explicitly get an instance of a menu.
   * Useful for defining hooks on a specific instance
   *
   * @return MarkupSimpleNaviation
   */
  private function __get_menu_instance()
  {
    $modules = PW\wire('modules');

    if ($modules->isInstalled('MarkupSimpleNavigation')) {
      $menu = $modules->get('MarkupSimpleNavigation');
    } else {
      trigger_error('MarkupSimpleNavigation must be added as a module to use ' . __FUNCTION__ . '()', E_USER_ERROR);

      return false;
    }

    return $menu;
  }

  /**
   * __render
   *
   * @param  array $options - options passed to MarkupSimpleNavgation
   * @param  null $current_page - current page
   * @param  null $entries - pages to render in the menu
   * @param  null $menu - an instance of a menu
   * @return
   */
  private function __render($options = [], $current_page = null, $entries = null, $menu = null)
  {
    if (is_null($menu)) {
      $menu = $this->__get_menu_instance();
    }

    $options = array_merge(array(
      'current_class'    => 'menu__item--current',
      'inner_tpl'        => '<ul class="menu menu__sub">||</ul>',
      'item_current_tpl' => '<a href="{url_nav|url}">{title}</a>',
      'item_tpl'         => '<a href="{url_nav|url}">{title}</a>',
      'list_field_class' => 'menu__item',
      'outer_tpl'        => '<ul class="menu">||</ul>',
      'parent_class'     => 'menu__item--current-parent',
      'selector'         => 'template!=rss',
      'show_root'        => true,
    ), $options);

    return $menu->render($options, $current_page, $entries);
  }
}
