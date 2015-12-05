<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Listener;

use OldTown\Workflow\ZF2\Event\WorkflowManagerEvent;
use OldTown\Workflow\ZF2\ServiceEngine\Event\WorkflowTypeResolverEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use OldTown\Workflow\ZF2\ServiceEngine\Service\Manager as WorkflowServiceManager;
use OldTown\Workflow\ZF2\ServiceEngine\TypeResolver\ChainTypeResolverInterface;

/**
 * Class InjectTypeResolver
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Listener
 */
class InjectTypeResolver extends AbstractListenerAggregate
{
    use EventManagerAwareTrait;

    /**
     * @var string
     */
    const WORKFLOW_SERVICE_MANAGER = 'workflowServiceManager';

    /**
     * @var string
     */
    const CHAIN_TYPE_RESOLVER = 'chainResolver';

    /**
     * @var WorkflowServiceManager
     */
    protected $workflowServiceManager;

    /**
     * @var ChainTypeResolverInterface
     */
    protected $chainTypeResolver;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        call_user_func_array([$this, 'init'], $options);
    }

    /**
     * @param WorkflowServiceManager     $workflowServiceManager
     * @param ChainTypeResolverInterface $chainResolver
     */
    protected function init(WorkflowServiceManager $workflowServiceManager, ChainTypeResolverInterface $chainResolver)
    {
        $this->setWorkflowServiceManager($workflowServiceManager);
        $this->setChainTypeResolver($chainResolver);
    }

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(WorkflowManagerEvent::EVENT_CREATE, [$this, 'createWorkflowManager'], -80);
    }

    /**
     * Обработчки по умолчанию
     */
    protected function attachDefaultListeners()
    {
        $this->getEventManager()->attach(WorkflowTypeResolverEvent::INJECT_WORKFLOW_TYPE_RESOLVER, [$this, 'addServiceTypeResolver']);
    }

    /**
     * Добавляет поддержку сервисов
     *
     * @param WorkflowTypeResolverEvent $event
     */
    public function addServiceTypeResolver(WorkflowTypeResolverEvent $event)
    {
        $chainTypeResolver = $event->getChainTypeResolver();
    }

    /**
     * Обработччик отвечающий за иньъекцию в менеджер workflow, поддержки запуска сервисов
     *
     * @param WorkflowManagerEvent $event
     */
    public function createWorkflowManager(WorkflowManagerEvent $event)
    {
        $workflowManager = $event->getWorkflowManager();
        $originalTypeResolver = $workflowManager->getResolver();
        $chainTypeResolver = $this->getChainTypeResolver();
        $resolver = $chainTypeResolver->add($originalTypeResolver, 1);

        $workflowTypeResolverEvent = new WorkflowTypeResolverEvent();
        $workflowTypeResolverEvent->setName(WorkflowTypeResolverEvent::INJECT_WORKFLOW_TYPE_RESOLVER);
        $workflowTypeResolverEvent->setWorkflowManager($workflowManager);
        $workflowTypeResolverEvent->setChainTypeResolver($chainTypeResolver);
        $workflowTypeResolverEvent->setTarget($this);
        $this->getEventManager()->trigger($workflowTypeResolverEvent);

        $workflowManager->setTypeResolver($resolver);
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
