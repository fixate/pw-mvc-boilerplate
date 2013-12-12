<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
	use SEO;
	use VideoEmbed;
	use PrimaryNav;

	function before() {
		SEO::__seoInitialize();
		VideoEmbed::__vidembedInitialize();
		PrimaryNav::__pnInitialize();
	}

  // Fallback index
  function index() {
    return $this->render($this->config->page->template->name);
  }
}

