<?php
return [
    'created_at' => [
        'title' => 'Fecha en que se llenó el documento',
        'type' => 'date',
    ],
    'tipo_de_intervencion' => [
        'title' => 'Tipo de intervención',
        'type' => 'select',
        'options' => ['Orientación/Consejo', 'Evaluación', 'Intervención breve', 'Psicoterapia', 'Intervención Psicoeducativa']
    ],
    'modelo_psicoterapia' => [
        'title' => 'Si el tipo de intervención es  psicoterapia, ¿cuál es el modelo?',
        'type' => 'text'
    ],
    'modalidad_de_servicio' => [
        'title' => 'Modalidad de servicio',
        'type' => 'select',
        'options' => ['Individual', 'Pareja', 'Familiar', 'A padres o cuidadores', 'Grupal']
    ],
    'sugerencias_de_intervencion' => [
        'title' => 'Sugerencias de intervención de servicio',
        'type' => 'area',
        'required' => true
    ],
];