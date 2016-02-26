<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Reader;

use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;

/**
 * Interface ReaderInterface
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Reader
 */
interface ReaderInterface
{
    /**
     * Получение метаданных для сервиса
     *
     * @param string  $serviceClassName
     * @param  string $serviceMethod
     *
     * @return MetadataInterface
     */
    public function loadMetadataForClassService($serviceClassName, $serviceMethod);
}
