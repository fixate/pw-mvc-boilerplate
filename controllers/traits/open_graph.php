<?php

trait OpenGraph {
	static function __ogInitialize($obj) {
		$obj->helper('opengraph_meta_tags');
	}

	private $__og_opts = array(
		'site_name' => false,
		'title_get' => 'title',
		'canonical_url' => false,
		'object_type' => false,
		'object_type_default' => 'website',
		'description' => false,
		'description_get' => 'summary',
		'image_get' => 'image|images'
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
			'site_name' => $this->__og_get_sitename(),
			'type' => $this->__og_opts['object_type'] ? $this->__og_opts['object_type'] : $this->__og_opts['object_type_default'],
			'title' => $this->__og_get_prop('title'),
			'url'   => $this->__og_opts['canonical_url'] ? $this->__og_opts['canonical_url'] : $this->page->httpUrl,
			'description' => $this->__og_opts['description'] ? $this->_og_opts['description'] : $this->__og_get_prop('description'),
			'image' => $this->__og_image_meta($image)
		);

		$tags = array_merge($tags, $this->__og_custom_tags);

		return $this->__og_render_tags($tags);
	}

	private function __og_get_prop($prop, $field = null, $default = null) {
		$prop = $this->page->get($this->__og_opts["{$prop}_get"]);

		if ($prop && method_exists($this->page, $prop)) {
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

	private function __og_get_sitename() {
		if ($this->__og_opts['site_name']) {
			return $this->__og_opts['site_name'];
		}

		return strlen($site_name = $this->pages->get('/settings')->site_name) !== 0 ? $site_name : null;
	}

	private function __og_image_meta($image) {
		$config =& $this->config;
		$hostname = 'http://' . $config->httpHost;

		if ($image) {
			if (is_array($image)) {
				foreach ($image as &$item) {
					$item = $hostname . $item;
				}

				return $image;
			}

			return $hostname . $image->url;
		}

		return null;
	}

	private function __og_render_tags($tags) {
		$html = '';
		foreach ($tags as $name => $value) {
			if ($value !== null) {
				if (is_array($value)) {
					foreach ($value as $v) {
						$html .= $this->__og_tag_markup($name, $v);
					}
				} else {
					$html .= $this->__og_tag_markup($name, $value);
				}
			}
		}

		return $html;
	}

	private function __og_tag_markup($name, $value) {
		return "<meta property='og:{$name}' content='{$value}'/>";
	}
}

