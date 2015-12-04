<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine;


use OldTown\Workflow\ZF2\ServiceEngine\Options\ModuleOptions;
use OldTown\Workflow\ZF2\ServiceEngine\Options\ModuleOptionsFactory;;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager;
use OldTown\Workflow\ZF2\ServiceEngine\Service\ManagerFactory;

return [
    'service_manager'           => [
        'factories'          => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            Manager::class => ManagerFactory::class
        ],
        'abstract_factories' => [

        ]
    ],
    'workflow_zf2_serviceEngine'         => [
    ],
    'workflow_zf2_service'         => [
        'invokables' => [],
        'factories'          => [],
        'abstract_factories' => [],
        'aliases' => []
    ]
];