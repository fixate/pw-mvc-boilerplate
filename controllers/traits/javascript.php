<?php

use fixate as f8;

trait Javascript {
	static function __jsInitialize($obj) {
		$obj->helper('js_add_vendor');
		$obj->helper('js_add_script');
		$obj->helper('js_add_cdn');
		$obj->helper('render_scripts');
		$obj->helper('render_js_data');
	}

	private $__js_scripts = array();

	function js_add_vendor($vendor) {
		if ($main = $this->__load_bower_main($vendor)) {
			if (is_array($main)) {
				$main = $main[0];
			}

			$path = "vendor/%%/{$main}";
		} else {
			$path = "vendor/%%/%%";
		}

		$this->__js_scripts[] = array('vendor', $vendor, $path, null);
	}

	function js_add_script($script, $path_tmpl = 'js/%%') {
		$this->__js_scripts[] = array('user', $script, $path_tmpl, null);
	}

	function js_add_cdn($url, $detect = false, $fallback = false) {
		$this->__js_scripts[] = array('cdn', null, null, $url, array($detect, $fallback));
	}

	function render_scripts() {
		$html = '';
		foreach ($this->__js_scripts as $script) {
			list($type, $vendor, $script_path, $url) = $script;
			switch ($type) {
			case 'user':
			case 'vendor':
				$path = str_replace('%%', $vendor, array_pop($script));
				$has_ext = f8\Paths::get_extension($path) == 'js';
				if (!$has_ext) {
					$path = f8\Paths::change_extension($path, 'js');
				}
				$path = $this->view->assets($path, !$has_ext);
				$html .= $this->__script_tag($path);
				break;
			case 'cdn':
				$html .= $this->__cdn_tag($url, array_pop($script));
				break;
			}
		}

		return $html;
	}

	function render_js_data() {
		$page = $this->page;
		return '<script>window.processWire = '.wireEncodeJSON(array(
			'page' => $page->name,
			'template' => $page->template->name,
		)).'</script>';
	}

	private function __cdn_tag($url, $fallback = false) {
		$html = $this->__script_tag($url);
		if ($fallback) {
			list($detect, $asset) = $fallback;
			$asset = $this->view->assets($asset);
			$html .= "<script>({$detect}) || document.write('<script src=\"{$asset}\">\\x3C/script>')</script>";
		}
		return $html;
	}

	private function __load_bower_main($vendor) {
		$tries = array('.bower.json', 'bower.json', 'component.json');

		foreach ($tries as $t) {
			$file = f8\Paths::join(TEMPLATE_DIR, "assets/vendor/{$vendor}/{$t}");
			if (file_exists($file)) {
				$manifest = json_decode(file_get_contents($file), true);
				if (array_key_exists('main', $manifest)) {
					return $manifest['main'];
				}
			}
		}
		return null;
	}

	private function __script_tag($src) {
		return "<script type=\"text/javascript\" src=\"{$src}\"></script>";
	}
}
