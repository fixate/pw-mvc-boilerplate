<?php
/**
 * Application Controller.
 *
 * Base controller all other controllers extend. index() in this
 * controller is used if not provided in template-specific controller.
 */
\fixate\Php::require_all(TEMPLATE_DIR.'/controllers/traits');

class ApplicationController extends Controller
{
    use Javascript;
    use OpenGraph;
    use Presenters;
    use PrimaryMenu;
    use SEO;
    use Search;
    use Twitter;
    use VideoEmbed;
    use Utils;

    public function initialize()
    {
        Javascript::__jsInitialize($this);
        OpenGraph::__ogInitialize($this);
        Presenters::__presenterInitialize($this);
        PrimaryMenu::__pnInitialize($this);
        SEO::__seoInitialize($this);
        Search::__searchInitialize($this);
        Twitter::__twInitialize($this);
        VideoEmbed::__vidembedInitialize($this);
        Utils::__utilsInitialize($this);

        $this->js_add_cdn(
            '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
            'window.jQuery',
            'vendor/jquery/dist/jquery.js'
        );
    }

    // Fallback index
    public function index()
    {
        return $this->render($this->config->page->template->name);
    }
}
