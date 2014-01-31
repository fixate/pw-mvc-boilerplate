<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
	use Javascript;
	use SEO;
	use VideoEmbed;
	use PrimaryNav;
	use Utils;

	function initialize() {
		Javascript::__jsInitialize($this);
		SEO::__seoInitialize($this);
		VideoEmbed::__vidembedInitialize($this);
		PrimaryNav::__pnInitialize($this);
		Utils::__utilsInitialize($this);

		$this->js_add_cdn(
			'//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js',
			'window.jQuery',
			'vendor/jquery/jquery.js'
		);
	}

  // Fallback index
  function index() {
		return $this->render($this->config->page->template->name);
  }
}

