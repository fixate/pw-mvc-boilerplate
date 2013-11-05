<?php
/**
 * Primary nav partial
 *
 * This partial is included via header.inc.php
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
?>
<nav id="nav" role="navigation">
  <ul class="menu menu-primary">
  <?php
    // TODO: move function into functions + bug fix
    // or...
    // use Soma's MarkupSimpleNavigation...
    function treeMenu(Page $page = null, Page $rootPage = null) {
        if(is_null($page)) $page = wire('page');
        if(is_null($rootPage)) $rootPage = wire('pages')->get('/');
        $out = "\n<ul>";
        $parents = $page->parents;
        $children = $rootPage->children;
        if($rootPage->id == 1) $children->prepend($rootPage);
        foreach($children as $child) {
                $class = '';
                $s = '';
               if($child->numChildren && $child->id > 1 && $parents->has($child)) {
                        $class = 'active';
                        $s = str_replace("\n", "\n\t\t", treeMenu($page, $child));

                } else if($child === $page) {
                        $class = "active";
                        if($page->numChildren && $page->id > 1) $s = str_replace("\n", "\n\t\t", treeMenu($page, $page));
                }

                if($class) $class = " class='$class'";
                $out .= "\n\t<li$class>\n\t\t<a href='{$child->url}'>{$child->title}</a>$s\n\t</li>";
        }

        $out .= "\n</ul>";
        return $out;
}

echo treeMenu();
?></ul>
</nav>
