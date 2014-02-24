<?php

class Application {
	public $config = null;
	public $page = null;
	public $session = null;

	static function instance() {
		static $instance = null;
		if ($instance == null) {
			$instance = new static();
		}

		return $instance;
	}

	static function init($config, $page, $session) {
		self::instance()->config = $config;
		self::instance()->page = $page;
		self::instance()->session = $session;
	}

	static function run() {
		$controller = Controller::dynamic_load(self::instance());
		if (!$controller) {
			self::set_http_status(404);
			return false;
		}

		$controller->before();

		if ($resp = $controller->call()) {
			echo $resp->body();
		}

		$controller->after($resp);

		return true;
	}

	private function __clone() {
		trigger_error("Clone disabled for singleton class.", E_ERROR);
	}
}
