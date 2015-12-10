<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Service;

/**
 * Interface ProviderInterface
 *
 * @package OldTown\Workflow\ZF2\Service\Service
 */
interface ProviderInterface
{
    /**
     * @return array
     */
    public function getWorkflowServiceConfig();
}
