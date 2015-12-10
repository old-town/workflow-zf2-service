<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\PropertySet\PropertySetInterface;
use OldTown\Workflow\ConditionInterface;
use OldTown\Workflow\TransientVars\TransientVarsInterface;

/**
 * Class FunctionWrapper
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver
 */
class ConditionWrapper extends AbstractWrapper implements ConditionInterface
{
    /**
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     * @param PropertySetInterface   $ps
     *
     * @return bool
     */
    public function passesCondition(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = static::getServiceUtil();
        $service = $this->getService();
        $listArguments = $serviceUtil->buildArgumentsForService($service, $transientVars, $args);

        $result = (boolean)call_user_func_array($service, $listArguments);

        return $result;
    }
}
