<?php

trait OpenGraph {
	static function __ogInitialize($obj) {
		$obj->helper('opengraph_meta_tags');
	}

	private $__og_opts = array(
		'image_get' => 'thumbnail|image|images',
		'title_get' => 'title',
		'canonical_url' => false,
		'object_type' => false,
		'object_type_default' => 'website',
		'site_name' => false
	);

	private $__og_custom_tags = [];

	protected function og_set_opt($opt, $value) {
		$this->__og_opts[$opt] = $value;
	}

	protected function og_add_tag($tag, $value) {
		$this->__og_custom_tags[$tag] = $value;
	}

	function opengraph_meta_tags() {
		$image = $this->__og_get_prop('image', 'url');
		$tags = array(
			'site_name' => $this->__og_opts['site_name'],
			'type' => $this->__og_opts['object_type'] ? $this->__og_opts['object_type'] : $this->__og_opts['object_type_default'],
			'title' => $this->__og_get_prop('title'),
			'url'   => $this->__og_opts['canonical_url'] ? $this->__og_opts['canonical_url'] : $this->page->httpUrl,
			'image' => $this->__og_image_meta($image)
		);

		$tags = array_merge($tags, $this->__og_custom_tags);

		return $this->__og_render_tags($tags);
	}

	private function __og_get_prop($prop, $field = null, $default = null) {
		$prop = $this->page->get($this->__og_opts["{$prop}_get"]);

		if ($prop && method_exists($prop, 'count')) {
			if ($prop->count() == 0) {
				return $default;
			} elseif ($prop->count() > 1) {
				$prop = $this->__og_get_prop_array($prop, $field);
			} else {
				$prop = $prop->first();
			}
		}

		if (!$prop) {
			return $default;
		}

		return $prop;
	}

	private function __og_get_prop_array($prop, $field) {
		$prop_array = [];

		foreach ($prop as $p) {
			array_push($prop_array, $p->$field);
		}

		return $prop_array;
	}

	private function __og_image_meta($image) {
		if ($image) {
			if (is_array($image)) {
				return $image;
			}

			return $image->url;
		}
		return null;
	}

	private function __og_render_tags($tags) {
		$html = '';
		foreach ($tags as $name => $value) {
			if ($value !== null && !is_array($value)) {
				$html .= $this->__og_tag_markup($name, $value);
			}

			if (is_array($value)) {
				foreach ($value as $v) {
					$html .= $this->__og_tag_markup($name, $v);
				}
			}
		}
		return $html;
	}

	private function __og_tag_markup($name, $value) {
		return "<meta property='og:{$name}' content='{$value}'/>";
	}
}

