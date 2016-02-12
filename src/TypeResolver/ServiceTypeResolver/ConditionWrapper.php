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
     *
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\RuntimeException
     */
    public function passesCondition(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = $this->getServiceUtil();
        $service = $this->getService();
        $metadata = $this->getMetadata();
        $listArguments = $serviceUtil->buildArgumentsForService($service, $metadata, $transientVars, $args);

        return (boolean)call_user_func_array($service, $listArguments);
    }
}
