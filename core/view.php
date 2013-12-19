<?php

use fixate as f8;

class ViewException extends Exception {}

class View implements IView {
	protected static $helpers = array();
	protected $layout = 'application';
	protected $data = array();
	public $controller = null;

	function __construct(IController &$controller, $name) {
		$this->controller = $controller;
		$this->name = $name;
	}

	// Spit out the page
	function spit() {
		echo $this->render_file($this->name);
	}

	function partial($name, $data = array()) {
		return $this->render_file(f8\Paths::join('partials', $name), $data);
	}

	function assets($path, $use_min = true) {
		if ($use_min) {
			$ext = f8\Paths::get_extension($path);
			// Only css and js
			if ($ext == 'js' || $ext == 'css') {
				$is_min = f8\Strings::ends_with($path, ".min.${ext}") !== false;

				// If in production change file to use .min extension
				if (Environment::is_production() && !$is_min && $use_min) {
					$path = f8\Paths::change_extension($path, "min.{$ext}");
				}
			}
		}

		$templates = $this->controller->config->urls->templates;
		return f8\Paths::join($templates, 'assets', $path);
	}

	function set_layout($name) {
		$this->layout = $name;
		return $this;
	}

	function add_data($data) {
		if ($data) {
			$this->data = array_merge($this->data, $data);
		}
		return $this;
	}

	function set_asset_uri($uri) {
		$this->assets_uri = $uri;
		return $this;
	}

	function set_base_path($path) {
		$this->base_path = $path;
		return $this;
	}

	function render() {
		if (!isset($this->layout)) {
			return '';
		}

		return $this->render_file("layouts/{$this->layout}");
	}

	protected function render_file($file, $_data = array(), $fallback = null) {
		if (!($_base_path = $this->base_path)) {
			$_base_path = f8\Paths::resolve(f8\Paths::join(dirname(__FILE__), '../views'));
		}

		if (!isset($this->data)) {
			$this->data = array();
		}

		$_path = f8\Paths::join($_base_path, $file);
		if (!f8\Strings::ends_with($_path, '.html.php')) {
			$_path .= '.html.php';
		}

		$view = $this;
		$page = $this->controller->page;
		$pages = wire('pages');
		$config = $this->controller->config;
		$env = Environment::get_instance();
		extract(array_merge($_data, $this->data));

		ob_start();
		try {
			if (!file_exists($_path)) {
				if (is_callable($fallback)) {
					echo $fallback($this);
				} else {
					throw new ViewException("Template {$file} does not exist.");
				}
			} else {
				include $_path;
			}
		} catch (Exception $ex) {
			return ob_get_clean() . "ERROR in View: ".$ex->getMessage();
		}
		return ob_get_clean();
	}

	public function __call($method, $args) {
		if (property_exists(__CLASS__, $method) && is_callable($method)) {
			return call_user_func_array(array($this, $method), $args);
		} else {
			if (in_array($method, array_keys(self::$helpers))) {
				$method = self::$helpers[$method];
				if (!is_callable($method)) {
					if (is_array($method) && count($method) >= 2) { $method = $method[1]; }

					throw new ViewException("Method '{$method}' not found.");
				}

				if (is_array($method)) {
					return call_user_func_array($method, $args);
				} else {
					return call_user_func($method, $args);
				}
			} else {
				throw new ViewException("Method '{$method}' not found.");
			}
		}
	}

	static function add_helper($func) {
		if (is_array($func)) {
			$func_name = $func[1];
		} elseif (is_string($func)) {
			$func_name = $func;
		} else {
			$func_name = (string)$func;
		}

		self::$helpers[$func_name] = $func;
	}
}
