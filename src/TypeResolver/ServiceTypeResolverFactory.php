<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\Service\Service\Manager;
use OldTown\Workflow\ZF2\Service\Module;
use OldTown\Workflow\ZF2\Service\Options\ModuleOptions;

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
     * @throws \OldTown\Workflow\ZF2\Service\Exception\ErrorInitModuleException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $workflowServiceManager = $serviceLocator->get(Manager::class);

        /** @var Module $module */
        $module = $serviceLocator->get(Module::class);
        $metadataReaderManager = $module->getMetadataReaderManager();

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        $metadataReaderName = $moduleOptions->getMetadataReader();
        $metadataReaderOptions = $moduleOptions->getMetadataReaderOptions();
        $metadataReader = $metadataReaderManager->get($metadataReaderName, $metadataReaderOptions, false);

        $options = [
            'serviceManager' => $workflowServiceManager,
            'metadataReader' => $metadataReader
        ];

        return new ServiceTypeResolver($options);
    }
}
