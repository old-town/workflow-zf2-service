<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Service;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package OldTown\Workflow\ZF2\Service\Service
 */
class Manager extends AbstractPluginManager
{
    /**
     * @param mixed $plugin
     *
     * @return bool
     */
    public function validatePlugin($plugin)
    {
        return true;
    }
}
