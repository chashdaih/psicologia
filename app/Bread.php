<?php

namespace App;

class Bread
{
    public $bread_array = [
        [
            'title' => 'Procesos',
            'url' => [
                'base' => 'procedures',
                'par' => ''
            ]
        ]
    ];

    public function __construct($key, $proc = null, $doc = null)
    {
        $json = file_get_contents(__DIR__.'/processes.json');
        $titles = json_decode($json, true);

        array_push($this->bread_array, [
            'title' => $titles[$key]['process'],
            'url' => [
                'base' => 'procedures',
                'par' => $key
            ]
        ]);
        if ($proc) {
            array_push($this->bread_array, [
                'title' => $titles[$key]['procedures'][$proc]['name'],
                'url' => null
            ]);
        }
        if ($doc) {
            array_push($this->bread_array, [
                'title' => $titles[$key]['procedures'][$proc]['documents'][$doc],
                'url' => null
            ]);
        }
    }
}