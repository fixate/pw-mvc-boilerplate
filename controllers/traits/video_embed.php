<?php

require_once TEMPLATE_DIR.'/lib/video_embedder.php';

trait VideoEmbed {
	static function __vidembedInitialize($obj) {
		$obj->helper('video_embed');
	}
	/**
	 * Embed code for videos.
	 * Supports:
	 *  - Youtube: converts video links to embed links.
	 */
	function video_embed($url, $options = array()) {
		$options = array_merge(array(
			'width' => 560,
			'height' => 315,
			'allowfullscreen' => true
		), $options);

		$embedder = Embedder::factory($url);
		if ($embedder == null) {
			return $url;
		}

		return $embedder->code($options);
	}
}
