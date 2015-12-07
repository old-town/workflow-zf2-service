<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver\Util;

use OldTown\Workflow\TransientVars\TransientVarsInterface;

/**
 * Interface WrapperInterface
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver\Util
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
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     *
     * @return array
     */
    public function buildArgumentsForService(callable $service, TransientVarsInterface $transientVars, array $args = []);
}
