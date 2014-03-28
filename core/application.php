<?php

class Application {
	public $config = null;
	public $fields = null;
	public $input = null;
	public $page = null;
	public $pages = null;
	public $permissions = null;
	public $roles = null;
	public $sanitizer = null;
	public $session = null;
	public $templates = null;
	public $user = null;
	public $users = null;

	static function instance() {
		static $instance = null;
		if ($instance == null) {
			$instance = new static();
		}

		return $instance;
	}

	static function init($config, $fields, $input, $page, $pages, $permissions, $roles, $sanitizer, $session, $templates, $user, $users) {
		self::instance()->config = $config;
		self::instance()->fields = $fields;
		self::instance()->input = $input;
		self::instance()->page = $page;
		self::instance()->pages = $pages;
		self::instance()->permissions = $permissions;
		self::instance()->roles = $roles;
		self::instance()->session = $session;
		self::instance()->sanitizer = $sanitizer;
		self::instance()->templates = $templates;
		self::instance()->user = $user;
		self::instance()->users = $users;
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

