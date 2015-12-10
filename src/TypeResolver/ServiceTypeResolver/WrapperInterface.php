<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

/**
 * Interface WrapperInterface
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver
 */
interface WrapperInterface
{
    /**
     * @return callable
     */
    public function getService();
}
