<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver;

/**
 * Class AbstractWrapper
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver
 */
abstract class AbstractWrapper implements WrapperInterface
{
    /**
     * @var callable
     */
    protected $service;

    /**
     * @param callable $service
     */
    public function __construct(callable $service)
    {
        $this->service = $service;
    }

    /**
     * @return callable
     */
    public function getService()
    {
        return $this->service;
    }
}
