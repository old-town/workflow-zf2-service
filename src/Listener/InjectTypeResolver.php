<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Listener;

use OldTown\Workflow\ZF2\Event\WorkflowManagerEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager as WorkflowServiceManager;


/**
 * Class InjectTypeResolver
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Listener
 */
class InjectTypeResolver extends AbstractListenerAggregate
{
    /**
     * @var string
     */
    const WORKFLOW_SERVICE_MANAGER = 'workflowServiceManager';

    /**
     * @var WorkflowServiceManager
     */
    protected $workflowServiceManager;

    /**
     * @param array $options
     *
     * @throws  \OldTown\Workflow\ZF2\ServiceEngine\Listener\Exception\InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        $this->init($options);
    }

    /**
     * @param array $options
     *
     * @throws  \OldTown\Workflow\ZF2\ServiceEngine\Listener\Exception\InvalidArgumentException
     */
    protected function init(array $options = [])
    {
        if (!array_key_exists(static::WORKFLOW_SERVICE_MANAGER, $options)) {
            $errMsg = sprintf('option %s not found', static::WORKFLOW_SERVICE_MANAGER);
            throw new Exception\InvalidArgumentException($errMsg);
        }
        $this->setWorkflowServiceManager($options[static::WORKFLOW_SERVICE_MANAGER]);
    }

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(WorkflowManagerEvent::EVENT_CREATE, [$this, 'createWorkflowManager'], -80);
    }

    /**
     * Обработччик отвечающий за иньъекцию в менеджер workflow, поддержки запуска сервисов
     *
     * @param WorkflowManagerEvent $event
     */
    public function createWorkflowManager(WorkflowManagerEvent $event)
    {


    }

    /**
     * @return WorkflowServiceManager
     */
    public function getWorkflowServiceManager()
    {
        return $this->workflowServiceManager;
    }

    /**
     * @param WorkflowServiceManager $workflowServiceManager
     *
     * @return $this
     */
    public function setWorkflowServiceManager(WorkflowServiceManager $workflowServiceManager)
    {
        $this->workflowServiceManager = $workflowServiceManager;

        return $this;
    }

}
