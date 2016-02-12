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
     *
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\RuntimeException
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\NoVariableForResultException
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\InvalidFunctionResultException
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\InvalidMapResultException
     */
    public function execute(TransientVarsInterface $transientVars, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = $this->getServiceUtil();
        $service = $this->getService();

        $metadata = $this->getMetadata();

        $listArguments = $serviceUtil->buildArgumentsForService($service, $metadata, $transientVars, $args);

        $result = call_user_func_array($service, $listArguments);

        if ($metadata->getFlagUseResultMap()) {
            if (!is_array($result) && !$result instanceof Traversable) {
                $errMsg = 'Invalid function result';
                throw new Exception\InvalidFunctionResultException($errMsg);
            }
            foreach ($result as $key => $value) {
                if (!$metadata->hasResultMap($key)) {
                    $errMsg = sprintf('Map data for "%s" not found', $key);
                    throw new Exception\InvalidMapResultException($errMsg);
                }
                $mapData = $metadata->getResultMapByFrom($key);

                $to = $mapData->getTo();
                if ($transientVars->offsetExists($to) && false === $mapData->getOverride()) {
                    $errMsg = sprintf('Data already exist named %s', $to);
                    throw new Exception\InvalidMapResultException($errMsg);
                }
                $transientVars[$to] = $value;
            }
        }

        $resultVariableName = $metadata->getResultVariableName();
        if (null !== $resultVariableName) {
            if ($transientVars->offsetExists($resultVariableName) && false === $metadata->isAllowOverrideResult()) {
                $errMsg = sprintf('Data already exist named %s', $resultVariableName);
                throw new Exception\InvalidMapResultException($errMsg);
            }
            $transientVars[$resultVariableName] = $result;
        }
    }
}
