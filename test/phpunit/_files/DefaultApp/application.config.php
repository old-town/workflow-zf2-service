<?php

use \OldTown\Workflow\ZF2\ServiceEngine\PhpUnit\TestData\TestPaths;

return [
    'modules' => [
        'OldTown\\Workflow\\ZF2\\ServiceEngine'
    ],
    'module_listener_options' => [
        'module_paths' => [
            'OldTown\\Workflow\\ZF2\\ServiceEngine' => TestPaths::getPathToModule()
        ],
        'config_glob_paths' => []
    ]
];