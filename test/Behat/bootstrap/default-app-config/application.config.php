<?php

return [
    'modules' => [
        'OldTown\\Workflow\\ZF2',
        'OldTown\\Workflow\\ZF2\\ServiceEngine'
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            __DIR__ . '/config/*.php'
        ]
    ]
];
