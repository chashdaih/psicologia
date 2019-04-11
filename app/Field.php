<?php

class Field
{
    public function __construct($title, $type, $name, $nullable = false) {
        $this->title = $title;
        $this->type = $type;
        $this->name = $name;
        $this->nullable = $nullable;
    }

    public $title;
    public $type;
    public $name;
    public $nullable;

}