<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Interface MetadataReaderManagerInterface
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata
 */
interface MetadataReaderManagerInterface extends ServiceLocatorInterface
{
    /**
     * @param string $name
     * @param array  $options
     * @param bool   $usePeeringServiceManagers
     *
     * @return mixed
     */
    public function get($name, $options = [], $usePeeringServiceManagers = true);
}
