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
	public $config = null;

	private $view_vars = array();

  protected static $fallback_controller = null;

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

	function get_view_vars() {
		return $this->view_vars;
	}

	function call($func = 'index') {
		$view = $this->$func();
		if ($view && $view instanceof IView) {
			echo $view->render();
		}
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

		$view->set_base_path(f8\Paths::join($this->config->paths->templates, 'views'));
		$view->set_asset_uri(f8\Paths::join($this->config->urls->templates, 'assets'));
		if ($this->view_vars) {
			$view->add_data($this->view_vars);
		}
		$view->add_data($data);

		return $view;
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

  static function set_fallback_controller($controller) {
    self::$fallback_controller = $controller;
  }

  // Static functions
  static function run(&$config, &$page) {
    if (!$page->template) {
      return;
    }

    $template = str_replace('-', '_', (string)$page->template);
    $controller_path = f8\Paths::join($config->paths->templates, 'controllers', "{$template}_controller.php");
    $controller = f8\Strings::camel_case($template).'Controller';

    if (file_exists($controller_path)) {
      require_once $controller_path;
    } elseif (isset(self::$fallback_controller)) {
      $controller = self::$fallback_controller;
    } else {
      trigger_error("No controller defined for template '{$template}'", E_USER_ERROR);
      return false;
    }

    // Instantiate controller class
    $controller = new $controller($config, $page);
		if (method_exists($controller, 'before')) {
			$controller->before();
		}

    $controller->call();

		if (method_exists($controller, 'after')) {
			$controller->after();
		}

    return true;
  }
}
