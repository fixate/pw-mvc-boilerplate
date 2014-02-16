<?php

trait OpenGraph {
	static function __ogInitialize($obj) {
		$obj->helper('opengraph_meta_tags');
	}

	private $__og_opts = array(
		'image_get' => 'thumbnail|image|images',
		'title_get' => 'title',
		'canonical_url' => false,
		'site_type' => false,
		'site_name' => false
	);

	protected function og_set_opt($opt, $value) {
		$this->__og_opts[$opt] = $value;
	}

	function opengraph_meta_tags() {
		$image = $this->__og_get_prop('image');
		$tags = array(
			'site_name' => $this->__og_opts['site_name'],
			'site_type' => $this->__og_opts['site_type'],
			'url'   => $this->__og_opts['canonical_url'] ? $this->__og_opts['canonical_url'] : $this->page->httpUrl,
			'title' => $this->__og_get_prop('title'),
			'image' => $image ? $image->url : null
		);

		return $this->__og_render_tags($tags);
	}

	private function __og_get_prop($prop, $default = null) {
		$prop = $this->page->get($this->__og_opts["{$prop}_get"]);

		if ($prop && method_exists($prop, 'count')) {
			if ($prop->count() == 0) {
				return $default;
			}

			$prop = $prop->first();
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
