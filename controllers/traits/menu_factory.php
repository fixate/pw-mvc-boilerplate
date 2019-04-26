<?php

use ProcessWire as PW;

trait MenuFactory
{
    public static function __menuInitialize($obj)
    {
        $obj->helper('primaryMenu');
    }

    public function primaryMenu($options = array())
    {
        return $this->__renderMenu(array_merge(array(
            'outer_tpl' => '<ul class="menu--primary js-menu-primary">||</ul>',
        ), $options));
    }

    private function __renderMenu($options = array(), $current_page = null, $entries = null)
    {
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

        $modules = PW\wire('modules');

        if ($modules->isInstalled('MarkupSimpleNavigation')) {
            $treeMenu = $modules->get('MarkupSimpleNavigation');
        } else {
            trigger_error('MarkupSimpleNavigation must be added as a module to use '.__FUNCTION__.'()', E_USER_ERROR);

            return false;
        }

        return $treeMenu->render($options, $current_page, $entries);
    }
}
