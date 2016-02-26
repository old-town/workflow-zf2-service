<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Event;

use OldTown\Workflow\WorkflowInterface;
use OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolverInterface;
use Zend\EventManager\Event;

/**
 * Class WorkflowTypeResolverEvent
 *
 * @package OldTown\Workflow\ZF2\Service\Event
 */
class WorkflowTypeResolverEvent extends Event
{
    /**
     * На данное событие необходимо подписываться, в случае если необходимо добавить свой собственный резолвер,
     * в другом модуле
     *
     * @var string
     */
    const INJECT_WORKFLOW_TYPE_RESOLVER = 'inject.workflow.type.resolver';

    /**
     * @var WorkflowInterface
     */
    protected $workflowManager;

    /**
     * @var ChainTypeResolverInterface
     */
    protected $chainTypeResolver;

    /**
     * @return WorkflowInterface
     */
    public function getWorkflowManager()
    {
        return $this->workflowManager;
    }

    /**
     * @param WorkflowInterface $workflowManager
     *
     * @return $this
     */
    public function setWorkflowManager(WorkflowInterface $workflowManager)
    {
        $this->workflowManager = $workflowManager;

        return $this;
    }

    /**
     * @return ChainTypeResolverInterface
     */
    public function getChainTypeResolver()
    {
        return $this->chainTypeResolver;
    }

    /**
     * @param ChainTypeResolverInterface $chainTypeResolver
     *
     * @return $this
     */
    public function setChainTypeResolver(ChainTypeResolverInterface $chainTypeResolver)
    {
        $this->chainTypeResolver = $chainTypeResolver;

        return $this;
    }
}
