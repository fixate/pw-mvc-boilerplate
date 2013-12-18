<?php

class GoogleMap implements JsonSerializable {
	public $zoom = false;
	public $markers = array();
	public $center = null;

	function __construct(MapMarker $map = null) {
		if ($map) {
			$this->add_marker($map);
		}
	}

	function add_marker(MapMarker $marker, Array $extra_data = null) {
		$this->markers[] = array($marker, $extra_data);

		// If zoom hasnt been set, set it from the marker
		if ($this->zoom === false) {
			$this->set_zoom($marker->zoom);
		}

		// Same for center
		if (!isset($this->center)) {
			$this->set_center($marker->lat, $marker->lng);
		}
	}

	function set_center($lat, $lng) {
		$this->center = (object)compact('lat', 'lng');
	}

	function set_zoom($zoom) {
		$this->zoom = $zoom;
	}

	function jsonSerialize() {
		return $this->to_seriablizable_object();
	}

  function to_seriablizable_object() {
		$obj = (object)array(
			'zoom' => $this->zoom,
			'center' => $this->center,
			'markers' => array()
		);

		foreach ($this->markers as $marker) {
			list($m, $d) = $marker;
			$mrk = array(
				'address' => $m->address,
				'lat' => $m->lat,
				'lng' => $m->lng
			);

			$obj->markers[] = (object)(isset($d) ? array_merge($mrk, $d) : $mrk);
		}

		return $obj;
	}
}
