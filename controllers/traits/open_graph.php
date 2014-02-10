<?php

trait OpenGraph {
	static function __ogInitialize($obj) {
		$obj->helper('opengraph_meta_tags');
	}

	private $__og_opts = array(
		'image_get' => 'thumbnail|image|images',
		'title_get' => 'title',
		'canonical_url' => false,
		'site_type_get' => 'site_type',
		'site_type_default' => 'article',
		'site_name' => false
	);

	protected function og_set_opt($opt, $value) {
		$this->__og_opts[$opt] = $value;
	}

	function opengraph_meta_tags() {
		$tags = array(
			'image' => $this->__og_get_prop('image'),
			'title' => $this->__og_get_prop('title'),
			'url'   => $canonical_url ? $canonical_url : $this->page->httpUrl,
			'site_name' => $this->__og_opts['site_name'],
			'type' => $this->__og_get_prop('site_type', $this->__og_opts['site_type_default'])
		);

		return $this->__og_render_tags($tags);
	}

	private function __og_get_prop($prop, $default = null) {
		$prop = $this->page->get($this->__og_opts["{$prop}_get"]);
		if (is_array($prop)) {
			if (count($prop) == 0) {
				return $default;
			}

			$prop = $prop[0];
		}

		if (!$prop) {
			return $default;
		}

		return $prop;
	}

	private function __og_render_tags($tags) {
		$html = '';
		foreach ($tags as $name => $value) {
			if ($value !== null) {
				$html .= "<meta property='og:{$name}' content='{$value}'/>";
			}
		}
		return $html;
	}
}
