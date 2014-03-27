<?php

trait SEO {
	static function __seoInitialize($obj) {
		$obj->add_view_vars($obj->get_seo_vars());
	}

	function get_seo_vars() {
		$page =& $this->page;

		return array(
			'seo_title'   => $this->get_seo_title(),
			'seo_desc'    => $this->get_seo_desc(),
			'seo_noindex' => $this->get_seo_noindex()
		);
	}

	protected function get_seo_title() {
		$page =& $this->page;

		if (!($seo_title = $page->seo_title)) {
			$seo_title = $page->title;

			if (method_exists($this, 'setting') && $this->setting('site_name')) {
				return $seo_title . ' ' . $this->get_seo_separator()  . ' ' . $this->setting('site_name');
			}
		}

		return $seo_title;
	}

	protected function get_seo_desc() {
		$page =& $this->page;

		if ($page->seo_description) {
			return "<meta name='description' content='{$page->seo_description}'>";
		}

		return false;
	}

	protected function get_seo_noindex() {
		$page =& $this->page;

		if ($page->seo_noindex) {
			return "<meta name='robots' content='noindex, nofollow'>";
		}

		return false;
	}

	private function get_seo_separator() {
		$page =& $this->page;

		if (!($seo_deparator = $page->seo_separator)) {
			$seo_separator = '|';
		}

		return $seo_separator;
	}
}



