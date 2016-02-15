<?php

trait PrimaryMenu
{
    public static function __pnInitialize($obj)
    {
        $obj->helper('primary_menu');
    }

    /**
     * Get main navigation. This function checks for the existence of the
     * MarkupSimpleNavigation module before rendering a menu:
     * https://github.com/somatonic/MarkupSimpleNavigation#markupsimplenavigation-116.
     */
    public function primary_menu($options = array())
    {
        $options = array_merge(array(
            'current_class' => 'menu__item--current',
            'parent_class' => 'menu__item--current-parent',
            'outer_tpl' => '<ul class="menu--primary">||</ul>',
            'inner_tpl' => '<ul class="menu menu__sub">||</ul>',
            'selector' => 'template!=rss',
            'show_root' => true,
            'list_field_class' => 'menu__item menu__item--primary',
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
