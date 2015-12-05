<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine;


use OldTown\Workflow\ZF2\Service\Workflow;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager;
use OldTown\Workflow\ZF2\ServiceEngine\Service\ProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Listener\InjectTypeResolver;


/**
 * Class Module
 *
 * @package OldTown\Workflow\ZF2
 */
class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    InitProviderInterface,
    DependencyIndicatorInterface
{

    /**
     * Имя секции в конфиги приложения
     *
     * @var string
     */
    const CONFIG_KEY = 'workflow_zf2_serviceEngine';

    /**
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            'OldTown\\Workflow\\ZF2'
        ];
    }

    /**
     * @param EventInterface $e
     *
     * @return array|void
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var MvcEvent $e */
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /** @var Workflow $workflowService */
        $workflowService = $e->getApplication()->getServiceManager()->get(Workflow::class);
        $listener = $e->getApplication()->getServiceManager()->get(InjectTypeResolver::class);
        $workflowService->getEventManager()->attach($listener);
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }


    /**
     *
     * @param ModuleManagerInterface $manager
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \OldTown\Workflow\ZF2\ServiceEngine\Exception\ErrorInitModuleException
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!$manager instanceof ModuleManager) {
            $errMsg =sprintf('Module manager not implement %s', ModuleManager::class);
            throw new Exception\ErrorInitModuleException($errMsg);
        }
        /** @var ModuleManager $manager */

        /** @var ServiceLocatorInterface $sm */
        $sm = $manager->getEvent()->getParam('ServiceManager');

        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            Manager::class,
            'workflow_zf2_service',
            ProviderInterface::class,
            'getWorkflowServiceConfig'
        );
    }



} 