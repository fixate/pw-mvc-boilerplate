<?php
use fixate as f8;

class Manifest
{
	private $rev = array();

	final public static function initialize ($filename)
	{
		if (file_exists($filename)) {
			self::get_instance()->set('manifest', f8\Files::parse_json_file($filename));
		}
		else {
			self::get_instance()->set('manifest', []);
		}
	}

	function set($k, $v = null)
	{
		if (is_array($k)) {
			$this->rev = array_merge($this->rev, $k);
		} else {
			$this->rev[$k] = $v;
		}
	}

	private function get($key)
	{
		return $this->rev[$key];
	}

	public static function get_instance ()
	{
		static $instance = null;
		if ($instance == null) {
			$instance = new static();
		}

		return $instance;
	}

	public static function prod_path ($path) {
		$filename = f8\Paths::get_filename($path);
		$__rev = self::get_instance()->get('manifest');

		if (array_key_exists($filename, $__rev)) {
			$path = '/public/'.$path;
			$path = substr($path, 0, strlen($path) - strlen($filename)).$__rev[$filename];
		}
		return $path;
	}

	// Support getting Manifest singleton with static method calls
	static function __callStatic($method, $args) {
		if (method_exists(__CLASS__, $method)) {
			return call_user_func_array(array(self, $method), $args);
		}

		$instance = static::get_instance();

		if ($instance->has($method)) {
			return $instance->$method;
		}

		trigger_error("No such method for Environment::{$method}.", E_ERROR);
	}

	/**
	 *	Makes valls to static variables
	 */
	function __get($name) {
		if (array_key_exists($name, $this->rev)) {
			return $this->rev[$name];
		}

		return null;
	}
	function __set ($name, $value)
	{
		$this->rev[$name] = $value;
	}

	/**
	 * privateize this class
	 */
	protected function __construct () {}
	protected function __clone () {}
	public function __wakeup()
	{
		throw new Exception("Cannot unserialize singleton");
	}
}
