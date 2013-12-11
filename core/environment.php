<?php

class Environment {
	// String representing current environment (development, production etc)
	public static $env = array();

	private static $__environment = null;

	static function initialize(&$config) {
		self::$env['is_production'] = !self::$env['is_development'] =

		self::$env['env'] = self::$env['is_production'] ? 'production' : 'development';
	}

	static function is_production() {
		return self::env() == 'production';
	}

	static function is_development() {
		return self::env() == 'development';
	}

	static function env() {
		if (array_key_exists('env', self::$env)) {
			return self::$env['env'];
		}

		if ($env = getenv('PW_ENV')) {
			return $env;
		}

		if (self::$__environment) {
			return self::$__environment;
		}

		self::$__environment = file_exists(dirname($config->paths->templates) . '/config-dev.php') ?
			'development' : 'production';

		return self::$__environment;
	}

	static function set($k, $v = null) {
		if (is_array($k)) {
			self::$env = array_merge(self::$env, $k);
		} else {
			self::$env[$k] = $v;
		}
	}

	static function unset_key($k) {
		unset(self::$env[$k]);
	}

  static function __callStatic($method, $args) {
		if (method_exists(self, $method)) {
			return call_user_func_array(array(self, $method), $args);
		}

		if (array_key_exists($method, self::$env)) {
			return self::$env[$method];
		}

		trigger_error("No such method for Environment::{$method}.", E_ERROR);
	}
}
