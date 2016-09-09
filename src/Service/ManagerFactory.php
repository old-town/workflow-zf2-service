<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ManagerFactory
 *
 * @package OldTown\Workflow\ZF2\Service\Service
 */
class ManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = Manager::class;

    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Zend\ServiceManager\AbstractPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $manager = parent::createService($serviceLocator);
        if ($serviceLocator instanceof ServiceManager) {
            $manager->addPeeringServiceManager($serviceLocator);
        }

        return  $manager;
    }
}
