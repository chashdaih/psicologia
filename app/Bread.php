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

    public function __construct($key = null, $proc = null, $doc = null)
    {
        $json = file_get_contents(__DIR__.'/fields/processes.json');
        $titles = json_decode($json, true);

        if ($key) {
        array_push($this->bread_array, [
            'title' => $titles[$key]['process'],
            'url' => [
                'base' => 'procedures',
                'par' => $key
            ]
        ]);
        }
        if ($proc) {
            array_push($this->bread_array, [
                'title' => $titles[$key]['procedures'][$proc]['name'],
                'url' => [
                    'base' => 'procedure',
                    'par' => [$key, filter_var($proc, FILTER_SANITIZE_NUMBER_INT)]
                ]
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