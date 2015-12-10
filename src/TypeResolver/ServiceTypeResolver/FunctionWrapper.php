<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\PropertySet\PropertySetInterface;
use OldTown\Workflow\FunctionProviderInterface;
use OldTown\Workflow\TransientVars\TransientVarsInterface;
use Traversable;

/**
 * Class FunctionWrapper
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver
 */
class FunctionWrapper extends AbstractWrapper implements FunctionProviderInterface
{
    /**
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     * @param PropertySetInterface   $ps
     */
    public function execute(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = static::getServiceUtil();
        $service = $this->getService();
        $listArguments = $serviceUtil->buildArgumentsForService($service, $transientVars, $args);

        $result = call_user_func_array($service, $listArguments);

        if ($result instanceof Traversable) {
            foreach ($result as $key => $value) {
                $transientVars[$key] = $value;
            }
        }
    }
}
