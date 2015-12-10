<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\Service\Service\Manager;


/**
 * Class ServiceTypeResolverFactory
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver
 *
 * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
 */
class ServiceTypeResolverFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ServiceTypeResolver
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $workflowServiceManager = $serviceLocator->get(Manager::class);

        $options = [
            'serviceManager' => $workflowServiceManager
        ];

        $serviceTypeResolver = new ServiceTypeResolver($options);

        return $serviceTypeResolver;
    }
}
