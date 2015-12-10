<?php

use \OldTown\Workflow\ZF2\Service\PhpUnit\TestData\TestPaths;

return [
    'modules' => [
        'OldTown\\Workflow\\ZF2\\Service'
    ],
    'module_listener_options' => [
        'module_paths' => [
            'OldTown\\Workflow\\ZF2\\Service' => TestPaths::getPathToModule()
        ],
        'config_glob_paths' => []
    ]
];