<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use OldTown\Workflow\Basic\BasicWorkflow;
use OldTown\Workflow\Loader\CallbackWorkflowFactory;
use OldTown\Workflow\Spi\Memory\MemoryWorkflowStore;
use OldTown\Workflow\Util\DefaultVariableResolver;
use OldTown\Workflow\ZF2\ServiceEngine\Behat\Test\Service\TestService;

return [
    'workflow_zf2_service' => [
        'invokables' => [
            'callbackService' => TestService::class
        ]
    ],

    'workflow_zf2'    => [
        'configurations' => [
            'behat' => [
                'persistence' => [
                    'name' => MemoryWorkflowStore::class,
                    'options' => [

                    ]
                ],
                'factory' => [
                    'name' => CallbackWorkflowFactory::class,
                    'options' => [

                    ]
                ],
                'resolver' => DefaultVariableResolver::class,
            ]
        ],



        'managers' => [
            'behat' => [
                'configuration' => 'behat',
                'name' => BasicWorkflow::class
            ]
        ]
    ]
];
