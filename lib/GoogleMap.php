<?php

class GoogleMap implements JsonSerializable
{
    public $zoom = false;
    public $markers = array();
    public $center = null;

    public function __construct(MapMarker $map = null)
    {
        if ($map) {
            $this->add_marker($map);
        }
    }

    public function add_marker(MapMarker $marker, array $extra_data = null)
    {
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

    public function set_center($lat, $lng)
    {
        $this->center = (object) compact('lat', 'lng');
    }

    public function set_zoom($zoom)
    {
        $this->zoom = $zoom;
    }

    public function jsonSerialize()
    {
        return $this->to_seriablizable_object();
    }

    public function to_seriablizable_object()
    {
        $obj = (object) array(
            'zoom' => $this->zoom,
            'center' => $this->center,
            'markers' => array(),
        );

        foreach ($this->markers as $marker) {
            list($m, $d) = $marker;
            $mrk = array(
                'address' => $m->address,
                'lat' => $m->lat,
                'lng' => $m->lng,
            );

            $obj->markers[] = (object) (isset($d) ? array_merge($mrk, $d) : $mrk);
        }

        return $obj;
    }
}
