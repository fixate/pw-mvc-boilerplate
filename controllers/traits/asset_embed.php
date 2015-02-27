<?php

use fixate as f8;

trait AssetEmbed {
	static function __assetembedInitialize($obj) {
		$obj->helper('svg_embed');
	}
	/**
	 * Embed assets.
	 */
	function embed_inline_svg($path) {
		if (Environment::is_production()) {
			// If use MD5# manifest in use get proper path
			if (Environment::use_manifest()) {
				$path = '/public/'.$path;
				$path = Manifest::prod_path($path);
			}
		}

		$path = f8\Paths::join('assets', $path);
		$content = file_get_contents($path);
		return $content;
	}
}
