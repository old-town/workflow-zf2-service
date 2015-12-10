<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service;


use OldTown\Workflow\ZF2\Service\Listener\InjectTypeResolver;
use OldTown\Workflow\ZF2\Service\Listener\InjectTypeResolverFactory;
use OldTown\Workflow\ZF2\Service\Options\ModuleOptions;
use OldTown\Workflow\ZF2\Service\Options\ModuleOptionsFactory;;
use OldTown\Workflow\ZF2\Service\Service\Manager;
use OldTown\Workflow\ZF2\Service\Service\ManagerFactory;
use OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolver;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolverFactory;

return [
    'service_manager'           => [
        'invokables' => [
            ChainTypeResolver::class => ChainTypeResolver::class,
        ],
        'factories'          => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            Manager::class => ManagerFactory::class,
            InjectTypeResolver::class => InjectTypeResolverFactory::class,
            ServiceTypeResolver::class => ServiceTypeResolverFactory::class
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