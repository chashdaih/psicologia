<?php

namespace App;

class Option
{
    public $id;
    public $name;
    public $sub;

    public function __construct($id, $name, $sub = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sub = $sub;
    }
}