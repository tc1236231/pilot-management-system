<?php

namespace App\Services\RoutePlanner;

class Edge {
    public $start;
    public $end;
    public $weight;
    public $airway;

    public function __construct($start, $end, $weight, $airway) {
        $this->start = $start;
        $this->end = $end;
        $this->weight = $weight;
        $this->airway = $airway;
    }
}