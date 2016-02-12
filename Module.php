<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service;


use OldTown\Workflow\ZF2\ServiceEngine\Workflow;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use OldTown\Workflow\ZF2\Service\Service\Manager;
use OldTown\Workflow\ZF2\Service\Service\ProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use OldTown\Workflow\ZF2\Service\Listener\InjectTypeResolver;
use Zend\ModuleManager\Feature\LocatorRegisteredInterface;
use OldTown\Workflow\ZF2\Service\Metadata\MetadataReaderManagerInterface;
use OldTown\Workflow\ZF2\Service\Options\ModuleOptions;
use ReflectionClass;


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
    DependencyIndicatorInterface,
    LocatorRegisteredInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * Имя секции в конфиги приложения
     *
     * @var string
     */
    const CONFIG_KEY = 'workflow_zf2_serviceEngine';

    /**
     * Менеджер для работы с метаданными сервисов
     *
     * @var MetadataReaderManagerInterface
     */
    protected $metadataReaderManager;

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
                    __NAMESPACE__ => stream_resolve_include_path(__DIR__ . '/src/'),
                ),
            ),
        );
    }


    /**
     *
     * @param ModuleManagerInterface $manager
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \OldTown\Workflow\ZF2\Service\Exception\ErrorInitModuleException
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

        $this->setServiceLocator($sm);

        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            Manager::class,
            'workflow_zf2_service',
            ProviderInterface::class,
            'getWorkflowServiceConfig'
        );
    }

    /**
     * Менеджер для работы с метаданными сервисов
     *
     * @return MetadataReaderManagerInterface
     *
     * @throws Exception\ErrorInitModuleException
     */
    public function getMetadataReaderManager()
    {
        if ($this->metadataReaderManager) {
            return $this->metadataReaderManager;
        }

        try {
            $sl = $this->getServiceLocator();
            /** @var ModuleOptions $moduleOptions */
            $moduleOptions = $sl->get(ModuleOptions::class);

            $className = $moduleOptions->getMetadataReaderManagerClassName();

            $r = new \ReflectionClass($className);
            $instance = $r->newInstance();

            if (!$instance instanceof MetadataReaderManagerInterface) {
                $errMsg = sprintf('Metadata reader manager not implement %s', MetadataReaderManagerInterface::class);
                throw new Exception\ErrorInitModuleException($errMsg);
            }
            $this->metadataReaderManager = $instance;
        } catch (\Exception $e) {
            throw new Exception\ErrorInitModuleException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->metadataReaderManager;
    }

    /**
     * Устанавливает менеджер для работы с метаданными сервисов
     *
     * @param MetadataReaderManagerInterface $metadataReaderManager
     *
     * @return $this
     */
    public function setMetadataReaderManager(MetadataReaderManagerInterface $metadataReaderManager)
    {
        $this->metadataReaderManager = $metadataReaderManager;

        return $this;
    }




} 