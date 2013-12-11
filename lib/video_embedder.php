<?php

class EmbedderException extends Exception {}

abstract class Embedder {
	static function factory($url) {
		$embedder = null;
		if (YoutubeEmbedder::matches($url)) {
			$embedder = new YoutubeEmbedder();
		}

		$embedder->parse($url);

		return $embedder;
	}

	public $url = null;

	abstract function parse($url);

	abstract function code($options = null);
}

class YoutubeEmbedder extends Embedder {
	// YouTube
	const MATCH_RGX = '#^(https?:)?//(www\.)?youtube\.com#';

	public $vid = false;

	static function matches($url) {
		return preg_match(YoutubeEmbedder::MATCH_RGX, $url);
	}

	function parse($url) {
		$this->url = $url;
		$components = parse_url($url);
		if (!$components) {
			throw new EmbedderException('Malformed embeddable URL.');
		}

		$match = null;
		if ($query = $components['query']) {
			parse_str($query, $query);
			if (array_key_exists('v', $query)) {
				$this->vid = $query['v'];
				return true;
			}
		} elseif (preg_match('#^/embed/(.+)$#', $components['path'], $match)) {
			$this->vid = $match[1];
			return true;
		}

		throw new EmbedderException("Invalid YouTube url {$url}.");
	}

	function code($options = array()) {
		$allowfullscreen = $options['allowfullscreen'] ? 'allowfullscreen' : '';

		$embed = "//youtube.com/embed/{$this->vid}";
		return '<iframe width="'.$options['width'].'" height="'.$options['height'].
			'" src="'.$embed.'" frameborder="0" '.$allowfullscreen.'></iframe>';
	}
}
