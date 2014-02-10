<?php

/*
 * Utils
 * Various global helpers
 */
use fixate as f8;

trait Utils {
	static function __utilsInitialize($obj) {
		$obj->helper('slugify');
	}

	function slugify($str) {
		return f8\Strings::slugify($str);
	}
}
