<?php

trait Javascript {
	static function __jsInitialize($obj) {
		$obj->helper('js_add_vendor');
		$obj->helper('js_add_script');
		$obj->helper('render_scripts');
		$obj->helper('vendor_scripts');
	}

	private $__js_vendor = array();
	private $__js_user = array();

	function js_add_vendor($script) {
		$this->__js_vendor[] = $script;
	}

	function js_add_script($script) {
		$this->__js_user[] = $script;
	}

	function vendor_scripts() {
		return $this->__js_render($this->__js_vendor, 'vendor/%%/%%.js');
	}

	function render_scripts() {
		return $this->__js_render($this->__js_user, 'js/%%.js');
	}

	private function __js_render($scripts, $root = '') {
		$html = '';

		foreach ($scripts as $script) {
			$path = str_replace('%%', $script, $root);
			$html .= $this->__js_tag($this->view->assets($path));
		}

		return $html;
	}

	private function __js_tag($src) {
		return "<script type=\"text/javascript\" src=\"{$src}\"></script>";
	}
}
