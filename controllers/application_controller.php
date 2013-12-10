<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
	use SEO {
		SEO::initialize as private __seoInitialize;
	}

	use VideoEmbed {
		VideoEmbed::initialize as private __vidembedInitialize;
	}

	use PrimaryNav {
		PrimaryNav::initialize as private __pnInitialize;
	}

	function __construct(&$config, &$page) {
		parent::__construct($config, $page);

		__seoInitialize();
		__vidembedInitialize();
		__pnInitialize();
	}

  // Fallback index
  function index() {
    return $this->render();
  }
}
