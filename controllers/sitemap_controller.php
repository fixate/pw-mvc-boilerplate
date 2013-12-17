<?php
/**
 * Sitemap Controller
 *
 * Fields and functions specific to the sitemap template.
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */
class SitemapController extends ApplicationController {
	function index() {
		$pages = wire('pages');
		return $this->render(array(
			'pages_list' => $this->pages_list($pages->get("/"))
		));
	}





/*------------------------------------*\
	$FUNCTIONS
	\*------------------------------------*/
	/**
	 * Loop through pages of the site and output a list item for each with a link
	 *
	 * @param object $page    the page to use as the root for generating a list of children
	 */
	function pages_list($page) {
		$html = "<li><a href='{$page->url}'>{$page->title}</a> ";

		if ($page->numChildren) {
			$html .= "<ul>";
			foreach($page->children as $child) {
				$this->pages_list($child);
			}
			$html .= "</ul>";
		}

		$html .= "</li>";
		return $html;
	}
}
