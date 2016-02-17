<?php

trait MenuFactory
{
    public static function __menuInitialize($obj)
    {
        $obj->helper('primary_menu');
    }

    public function primary_menu($options = array())
    {
        return $this->__render_menu(array(
            'outer_tpl' => '<ul class="menu--primary js-menu-primary">||</ul>',
        ));
    }

    private function __render_menu($options = array())
    {
        $options = array_merge(array(
            'current_class' => 'menu__item--current',
            'parent_class' => 'menu__item--current-parent',
            'outer_tpl' => '<ul class="menu">||</ul>',
            'inner_tpl' => '<ul class="menu menu__sub">||</ul>',
            'selector' => 'template!=rss',
            'show_root' => true,
            'list_field_class' => 'menu__item',
            'item_tpl' => '<a href="{url_nav|url}">{title}</a>',
            'item_current_tpl' => '<a href="{url_nav|url}">{title}</a>',
        ), $options);

        $modules = wire('modules');

        if ($modules->isInstalled('MarkupSimpleNavigation')) {
            $treeMenu = $modules->get('MarkupSimpleNavigation');
        } else {
            trigger_error('MarkupSimpleNavigation must be added as a module to use '.__FUNCTION__.'()', E_USER_ERROR);

            return false;
        }

        return $treeMenu->render($options);
    }
}
