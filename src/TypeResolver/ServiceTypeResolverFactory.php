<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager;


/**
 * Class ServiceTypeResolverFactory
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver
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
