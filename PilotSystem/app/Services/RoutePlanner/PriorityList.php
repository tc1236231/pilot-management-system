<?php
namespace App\Services\RoutePlanner;

class PriorityList {
    public $next;
    public $data;
    function __construct($data) {
        $this->next = null;
        $this->data = $data;
    }
}