<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine;


use OldTown\Workflow\ZF2\ServiceEngine\Listener\InjectTypeResolver;
use OldTown\Workflow\ZF2\ServiceEngine\Listener\InjectTypeResolverFactory;
use OldTown\Workflow\ZF2\ServiceEngine\Options\ModuleOptions;
use OldTown\Workflow\ZF2\ServiceEngine\Options\ModuleOptionsFactory;;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager;
use OldTown\Workflow\ZF2\ServiceEngine\Service\ManagerFactory;
use OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ChainTypeResolver;

return [
    'service_manager'           => [
        'invokables' => [
            ChainTypeResolver::class => ChainTypeResolver::class
        ],
        'factories'          => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            Manager::class => ManagerFactory::class,
            InjectTypeResolver::class => InjectTypeResolverFactory::class
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