<?php
/**
 * Sitemap template
 *
 * This site uses the delegate approach: http://processwire.com/talk/topic/740-a-different-way-of-using-templates-delegate-approach/
 *
 * Make sure to set 'Alternate Template' to 'main.php' under Template Settings
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

function sitemapListPage($page) {

	echo "<li><a href='{$page->url}'>{$page->title}</a> ";

	if($page->numChildren) {
		echo "<ul>";
		foreach($page->children as $child) sitemapListPage($child);
		echo "</ul>";
	}

	echo "</li>";
}

echo "<ul class='sitemap'>";
sitemapListPage($pages->get("/"));
echo "</ul>";

