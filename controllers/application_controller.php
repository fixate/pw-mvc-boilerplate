<?php

\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller {
  use JavaScript;
	use SEO;
	use VideoEmbed;
	use PrimaryNav;
	use Search;

	function initialize() {
    JavaScript::__jsInitialize($this);
		SEO::__seoInitialize($this);
		VideoEmbed::__vidembedInitialize($this);
		PrimaryNav::__pnInitialize($this);
		Search::__searchInitialize($this);
	}

  // Fallback index
  function index() {
    return $this->render($this->config->page->template->name);
  }
}

