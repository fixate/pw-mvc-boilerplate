<?php

trait SEO {
	static function __seoInitialize($obj) {
		$obj->add_view_vars($obj->get_seo_vars());
	}

	function get_seo_title() {
		$page =& $this->page;
		$pages = wire('pages');
		$seo_title = '';

		if ($title = $page->seo_title) {
			$seo_title = $title;
		} else {
			$seo_title = $page->title;
			$seo_title .= ' ' . $pages->get('/settings/')->seo_title_append;
		}

		return $seo_title;
	}

	function get_seo_desc() {
		$page =& $this->page;

		if ($page->seo_description) {
			return '<meta name="description" content="{$page->seo_description}">';
		}
	}

	function get_seo_noindex() {
		$page =& $this->page;

		if ($page->seo_noindex) {
			return '<meta name="robots" content="noindex, nofollow">';
		}
	}

	function get_seo_vars() {
    $page =& $this->page;

		return array(
			'seo_title'   => $this->get_seo_title(),
			'seo_desc'    => $page->seo_desc,
			'seo_noindex' => $this->get_seo_noindex()
		);
	}
}


