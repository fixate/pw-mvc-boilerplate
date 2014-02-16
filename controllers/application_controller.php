<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
	use Javascript;
	use OpenGraph;
	use PrimaryNav;
	use SEO;
	use VideoEmbed;
	use Utils;

	function initialize() {
		$site_name = $this->site_name();
		$this->og_set_opt('site_name', $site_name);

		Javascript::__jsInitialize($this);
		OpenGraph::__ogInitialize($this);
		PrimaryNav::__pnInitialize($this);
		SEO::__seoInitialize($this, $site_name);
		VideoEmbed::__vidembedInitialize($this);
		Utils::__utilsInitialize($this);

		$this->js_add_cdn(
			'//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',
			'window.jQuery',
			'vendor/jquery/jquery.js'
		);
	}

	protected function site_name() {
		return $this->setting('site_name');
	}

  // Fallback index
  function index() {
		return $this->render($this->config->page->template->name);
  }
}

