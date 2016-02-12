<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\PropertySet\PropertySetInterface;
use OldTown\Workflow\RegisterInterface;
use OldTown\Workflow\Spi\WorkflowEntryInterface;
use OldTown\Workflow\TransientVars\BaseTransientVars;
use OldTown\Workflow\WorkflowContextInterface;

/**
 * Class RegisterWrapper
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver
 */
class RegisterWrapper extends AbstractWrapper implements RegisterInterface
{
    /**
     * @param WorkflowContextInterface $context
     * @param WorkflowEntryInterface   $entry
     * @param array                    $args
     * @param PropertySetInterface     $ps
     *
     * @return mixed
     *
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Exception\RuntimeException
     */
    public function registerVariable(WorkflowContextInterface $context, WorkflowEntryInterface $entry, array $args = [], PropertySetInterface $ps)
    {
        $serviceUtil = $this->getServiceUtil();
        $service = $this->getService();
        $transientVars = new BaseTransientVars([
            'context' => $context,
            'entry' => $entry
        ]);
        $metadata = $this->getMetadata();
        $listArguments = $serviceUtil->buildArgumentsForService($service, $metadata, $transientVars, $args);

        return call_user_func_array($service, $listArguments);
    }
}
