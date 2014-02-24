<?php

use fixate as f8;
/**
 * Base Controller
 *
 * Fields and functions that are globally accessible to all templates are defined
 * here. This controller is included in _init.php, and is available to all templates
 *
 * @package FixateProcesswire
 * @since Theme_Name 1.0
 */

abstract class Controller implements IController {
	public $page = null;
	public $session = null;
	public $config = null;

	private $view_vars = array();

	protected $view = null;
  protected static $fallback = null;

	function __construct(&$config, &$page, &$session) {
		$this->config = $config;
		$this->page = $page;
		$this->session = $session;

		$this->initialize();
	}

	function initialize() { /* override if required */ }

	function render($view_name = null, $data = null) {
		if ($view_name && is_array($view_name)) {
			$data = $view_name;
			$view_name = null;
		}

		if (!isset($view_name)) {
			$view_name = $this->get_implicit_view_name();
		} else {
			$view_name = self::clean_template($view_name);
		}

		return $this->view = $this->load_view($view_name, $data);
	}

	// Do nothing - override if required
	function before() {}
	function after($resp) {}

	function get_view_vars($name = null) {
		if ($name === null) {
			return $this->view_vars;
		}

		return $this->view_vars[$name];
	}

	function call($req) {
		$resp = new f8\HttpResponse();

		$func = 'page_'.f8\Strings::snake_case($this->page->name);
		if (!method_exists($this, $func)) {
			$func = 'index';
		}

		if (!($ret = $this->$func($req, $resp))) {
			return $resp;
		}

		if ($ret instanceof IView) {
			$resp->set_body($ret->render());
		}

		return $resp;
	}

	function helper($func) {
		if (!is_callable($func)) {
			$func = array($this, $func);
		}

		View::add_helper($func);
	}

	// Protected functions
	protected function get_implicit_view_name() {
		$view_name = f8\Strings::snake_case(get_class($this));
		return f8\Strings::rchomp($view_name, '_controller');
	}

	protected function load_view($view_name, $data) {
		$view = new View($this, $view_name);

		$view->set_layout(isset($this->layout) ? $this->layout : 'application');

		$view->set_base_path(f8\Paths::join($this->config->paths->templates, 'views'));
		$view->set_asset_uri(f8\Paths::join($this->config->urls->templates, 'assets'));
		if ($this->view_vars) {
			$view->add_data($this->view_vars);
		}
		$view->add_data($data);

		return $view;
	}

	protected function setting($name) {
		static $settings = null;
		if ($settings == null) {
			$settings = wire('pages')->get('/settings/');
		}

		return $settings->$name;
	}

  function add_view_vars($key, $value = null) {
		if (is_array($key)) {
			$vars = $key;
		} else {
			$vars = array($key => $value);
		}

		$this->view_vars = array_merge($this->view_vars, $vars);
		return $this;
	}

	static function clean_template($template) {
		return str_replace('-', '_', $template);
	}

  static function set_fallback($controller) {
    self::$fallback = $controller;
  }

	static function dynamic_load($app) {
		$config = $app->config;
		$page = $app->page;
		$session = $app->session;

		if (!$page->template) {
			return false;
		}

		$template = self::clean_template((string)$page->template);

		$path_args = array($config->paths->templates, 'controllers');
		// Ajax requests - load controller from api path
		if ($config->ajax) { $path_args[] = 'api'; }
		$path_args[] = "{$template}_controller.php";
		$controller_path = call_user_func_array('fixate\Paths::join', $path_args);

		$controller = f8\Strings::camel_case($template).'Controller';

		if (file_exists($controller_path)) {
			require_once $controller_path;
		} elseif (isset(self::$fallback)) {
			$controller = self::$fallback;
		} else {
			trigger_error("No controller defined for template '{$template}'", E_USER_ERROR);
			return false;
		}

		// Instantiate controller class
		return new $controller($config, $page, $session);
	}
}
