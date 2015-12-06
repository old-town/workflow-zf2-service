<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver;

use OldTown\PropertySet\PropertySetInterface;
use OldTown\Workflow\FunctionProviderInterface;
use OldTown\Workflow\TransientVars\TransientVarsInterface;

/**
 * Class FunctionWrapper
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver
 */
class FunctionWrapper extends AbstractWrapper implements FunctionProviderInterface
{
    public function execute(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        call_user_func($this->getService());
    }
}
