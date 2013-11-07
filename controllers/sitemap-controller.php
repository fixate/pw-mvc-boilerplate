<?php
/**
 * Sitemap Controller
 *
 * Fields and functions specific to the sitemap template.
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
/*------------------------------------*\
  $FIELDS
\*------------------------------------*/





/*------------------------------------*\
  $FUNCTIONS
\*------------------------------------*/
/**
 * Loop through pages of the site and output a list item for each with a link
 *
 * @since Theme_Name 1.0
 */
function theme_fn_prefix_pages_list($page) {

  echo "<li><a href='{$page->url}'>{$page->title}</a> ";

  if ($page->numChildren) {
    echo "<ul>";
    foreach($page->children as $child) theme_fn_prefix_pages_list($child);
    echo "</ul>";
  }

  echo "</li>";
}
