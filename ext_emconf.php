<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Brofix Widget',
    'description' => '',
    'category' => 'be',
    'author' => 'Jari-Hermann Ernst',
    'author_email' => 'webdev@jhernst.de',
    'state' => 'beta',
    'version' => '0.0.5',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'brofix' => '6.3.0-6.3.99',
            'cms-dashboard' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
