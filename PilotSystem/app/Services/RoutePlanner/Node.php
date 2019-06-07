<?php
namespace App\Services\RoutePlanner;

class Node {
    public $name;
    public $lat;
    public $lng;

    public function __construct($name, $lat, $lng) {
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function hashString()
    {
        $latStr = str_replace("-", "", $this->lat);
        $latStr = str_replace(".", "", $latStr);
        $lngStr = str_replace("-", "", $this->lng);
        $lngStr = str_replace(".", "", $lngStr);
        $latStr = Math::numToWord(substr($latStr, 0, 3));
        $lngStr = Math::numToWord(substr($lngStr, 0, 3));
        return $this->name . $latStr . $lngStr;
    }
}