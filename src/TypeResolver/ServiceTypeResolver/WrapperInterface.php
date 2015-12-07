<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver;

/**
 * Interface WrapperInterface
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver
 */
interface WrapperInterface
{
    /**
     * @return callable
     */
    public function getService();
}
