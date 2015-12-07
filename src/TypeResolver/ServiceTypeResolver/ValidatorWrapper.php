<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ServiceTypeResolver;

use OldTown\PropertySet\PropertySetInterface;
use OldTown\Workflow\TransientVars\TransientVarsInterface;
use OldTown\Workflow\ValidatorInterface;

/**
 * Class FunctionWrapper
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\TypeResolver
 */
class ValidatorWrapper extends AbstractWrapper implements ValidatorInterface
{
    /**
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     * @param PropertySetInterface   $ps
     */
    public function validate(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = static::getServiceUtil();
        $service = $this->getService();
        $listArguments = $serviceUtil->buildArgumentsForService($service, $transientVars, $args);

        call_user_func_array($service, $listArguments);
    }
}
