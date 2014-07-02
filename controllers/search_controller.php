<?php
/**
 * Search Controller
 *
 * Fields and functions specific to the search template.
 *
 * @package ProcessWire
 */

class SearchController extends ApplicationController {
	function index() {
		$sanitizer = wire('sanitizer');
		$pages = wire('pages');

		$query = Search::get_query();
		$results = $pages->find("title|body%=$query, limit=50");
		$count = count($results);
		$result_str = ($count === 1) ? $count . ' result' : $count . ' results';

		return $this->render(compact(
			'results',
			'result_str',
			'count'
		));
	}
}
