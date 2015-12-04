<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Service;

/**
 * Interface ProviderInterface
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Service
 */
interface ProviderInterface
{
    /**
     * @return array
     */
    public function getWorkflowServiceConfig();
}
