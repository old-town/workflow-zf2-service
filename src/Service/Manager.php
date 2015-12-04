<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Service;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Service
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     */
    const DEFAULT_HANDLER = 'default';


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
