<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
	use SEO;
	use VideoEmbed;
	use PrimaryNav;

	function __construct(&$config, &$page) {
		parent::__construct($config, $page);

		// And this is why PHP sucks...
		SEO::__seoInitialize();
		VideoEmbed::__vidembedInitialize();
		PrimaryNav::__pnInitialize();
	}

  // Fallback index
  function index() {
    return $this->render();
  }
}
