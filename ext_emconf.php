<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Brofix Widget',
    'description' => '',
    'category' => 'be',
    'author' => 'Jari-Hermann Ernst',
    'author_email' => 'webdev@jhernst.de',
    'state' => 'experimental',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.3',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'brofix' => '6.3.0-6.3.99',
            'cms-dashboard' => '12.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
