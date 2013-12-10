<?php

use fixate as f8;

class ViewException extends Exception {}

class View implements IView {
	protected static $helpers = array();
	protected $layout = 'application';
	protected $data = array();
	public $controller = null;

	function __construct(&$controller, $name) {
		$this->controller = $controller;
		$this->name = $name;

		if (method_exists($controller, 'get_view_vars')) {
			$this->data = $controller->get_view_vars();
		}
	}

	function yield() {
		echo $this->render_file($this->name, array(), create_function('$view', 'return $view->body();'));
	}

	function body() {
		return $this->controller->page->body;
	}

	function partial($name, $data = array()) {
		return $this->render_file(f8\Paths::join('partials', $name), $data);
	}

	function set_layout($name) {
		$this->layout = $name;
		return $this;
	}

	function add_data($data) {
		$this->data = array_merge($data, $this->data);
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

		$_path = f8\Paths::join($_base_path, $file);
		if (!f8\Strings::ends_with($_path, '.html.php')) {
			$_path .= '.html.php';
		}

		$view = $this;
		$page = $this->controller->page;
    $config = $this->controller->config;
		extract(array_merge($_data, $this->data));

		ob_start();
		if (!file_exists($_path) && is_callable($fallback)) {
			echo $fallback($this);
		} else {
			include $_path;
		}
		return ob_get_clean();
	}

	public function __call($method, $args) {
		if (property_exists($method) && is_callable($method)) {
			return call_user_func_array(array($this, $method), $args);
		} else {
			if (in_array($method, array_keys(self::$helpers))) {
				$method = self::$helpers[$method];
				if (is_array($method)) {
					return call_user_func_array($method, $args);
				} else {
					return call_user_func($method, $args);
				}
			} else {
				throw new ViewException("Method {$method} not found.");
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

    if (!is_callable($func)) {
      throw new ViewException("Helper {$func} not callable.");
    }

		self::$helpers[$func_name] = $func;
	}
}
