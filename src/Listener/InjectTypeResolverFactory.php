<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\Service\Service\Manager;
use OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolver;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

/**
 * Class InjectTypeResolverFactory
 *
 * @package OldTown\Workflow\ZF2\Service\Listener
 */
class InjectTypeResolverFactory implements  FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return InjectTypeResolver
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \OldTown\Workflow\ZF2\Service\Listener\Exception\InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Manager $workflowServiceManager */
        $workflowServiceManager = $serviceLocator->get(Manager::class);
        $chainResolver = $serviceLocator->get(ChainTypeResolver::class);
        $serviceResolver = $serviceLocator->get(ServiceTypeResolver::class);

        $options = [
            InjectTypeResolver::WORKFLOW_SERVICE_MANAGER => $workflowServiceManager,
            InjectTypeResolver::CHAIN_TYPE_RESOLVER => $chainResolver,
            InjectTypeResolver::SERVICE_TYPE_RESOLVER => $serviceResolver
        ];

        $service = new InjectTypeResolver($options);

        return $service;
    }
}
