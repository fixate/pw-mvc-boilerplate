<?php

trait VideoEmbed {
	function initialize() {
		$this->helper('video_embed');
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

		$allowfullscreen = $options['allowfullscreen'] ? 'allowfullscreen' : '';

		$embed = $band->band_video;
		return '<iframe width="'.$options['width'].'" height="'.$options['height'].'" src="'.$embed.'" frameborder="0" '.$allowfullscreen.'></iframe>';
	}


}
