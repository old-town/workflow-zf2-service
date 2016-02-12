<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util;

use OldTown\Workflow\TransientVars\TransientVarsInterface;
use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;

/**
 * Interface WrapperInterface
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util
 */
interface ServiceUtilInterface
{
    /**
     * @param callable $service
     *
     * @return array
     */
    public function getListArgumentForService(callable $service);


    /**
     * Подготавливает список аргументов, для вызова сервиса
     *
     * @param callable               $service
     * @param MetadataInterface      $metadata
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     *
     * @return array
     */
    public function buildArgumentsForService(callable $service, MetadataInterface $metadata, TransientVarsInterface $transientVars, array $args = []);
}
