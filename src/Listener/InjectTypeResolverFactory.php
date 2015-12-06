<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager;
use OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ChainTypeResolver;

/**
 * Class InjectTypeResolverFactory
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Listener
 */
class InjectTypeResolverFactory implements  FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return InjectTypeResolver
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \OldTown\Workflow\ZF2\ServiceEngine\Listener\Exception\InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Manager $workflowServiceManager */
        $workflowServiceManager = $serviceLocator->get(Manager::class);
        $chainResolver = $serviceLocator->get(ChainTypeResolver::class);

        $options = [
            InjectTypeResolver::WORKFLOW_SERVICE_MANAGER => $workflowServiceManager,
            InjectTypeResolver::CHAIN_TYPE_RESOLVER => $chainResolver
        ];

        $service = new InjectTypeResolver($options);

        return $service;
    }
}
