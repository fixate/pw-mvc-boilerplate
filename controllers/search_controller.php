<?php
/**
 * Search Controller
 *
 * Fields and functions specific to the search template.
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

class SearchController extends ApplicationController {
	function index() {
		$sanitizer = wire('sanitizer');
		$pages = wire('pages');
		$input = wire('input');

		$query = $sanitizer->selectorValue($input->get->q);
		$results = $pages->find("title|body~=$query, limit=50");
		$count = count($results);
		$result_str = ($count === 1) ? $count . ' result' : $count . ' results';
		$q = $input->whitelist('q', $query);

		return $this->render(compact(
			'results',
			'result_str',
			'count',
			'q',
			'count_str'
		));
	}
}
