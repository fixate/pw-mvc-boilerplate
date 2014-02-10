<?php
namespace fixate;

/**
 * Provides a HttpResponse object
 *
 * ProcessWire 2.x
 * Copyright (C) 2011 by Stan Bondi
 * Licensed under GNU/GPL v2, see LICENSE.TXT
 *
 * http://www.processwire.com
 * http://www.fixate.it
 *
 */

class HttpResponse {
	protected $status = 0;
	protected $body = '';
	protected $headers = array();

	function __construct() {
		$this->headers = headers_list();
	}

	function set_header($name, $value) {
		$this->headers[$name] = $value;
		header("$name: $value");
	}

	function set_status($code) {
		$this->status = $code;
		http_response_code($code);
	}

	function set_body($body) {
		$this->body = $body;
	}

	function body() {
		return $this->body;
	}

	function status() {
		return $this->status;
	}

	function header($name) {
		return $this->headers[$name];
	}
}
