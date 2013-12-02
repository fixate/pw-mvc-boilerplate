<?php

use fixate as f8;
/**
 * Base Controller
 *
 * Fields and functions that are globally accessible to all templates are defined
 * here. This controller is included in _init.php, and is available to all templates
 *
 * @package ProcessWire
 * @since Theme_Name 1.0
 */

abstract class Controller implements IController {
	public $page = null;
	protected $config = null;

	function __construct(&$config, &$page) {
		$this->config = $config;
		$this->page = $page;
	}

	function render($view_name = null, $data = null) {
		if ($view_name && is_array($view_name)) {
			$data = $view_name;
			$view_name = null;
		}

		if (!isset($view_name)) {
			$view_name = $this->get_implicit_view_name();
		}

		return $this->load_view($view_name, $data);
	}

	abstract function index();

	function call($func = 'index') {
		$view = $this->$func();
		if ($view && $view instanceof IView) {
			echo $view->render();
		}
	}

	function helper($func) {
		View::add_helper($func);
	}

	// Protected functions
	protected function get_implicit_view_name() {
		$view_name = f8\Strings::snake_case(get_class($this));
		return f8\Strings::rchomp($view_name, '_controller');
	}

	protected function load_view($view_name, $data) {
		$view = new View($this, $view_name);

		$view->set_base_path(f8\Paths::join($this->config->paths->templates, views));
		$view->set_asset_uri(f8\Paths::join($this->config->urls->templates, 'assets'));
		$view->add_data($data);

		return $view;
	}

	// Static functions
	static function run(&$config, &$page) {
		if (!$page->template) {
			return;
		}

		$template = str_replace('-', '_', (string)$page->template);
		$controller_path = "{$config->paths->templates}/controllers/{$template}_controller.php";

		if (file_exists($controller_path)) {
			require_once $controller_path;

			// Instantiate controller class
			$class = \fixate\Strings::camel_case($template).'Controller';
			$controller = new $class($config, $page);
			$controller->call();
		}
	}
}
