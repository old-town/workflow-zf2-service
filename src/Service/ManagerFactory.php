<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

/**
 * Class ManagerFactory
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Service
 */
class ManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = Manager::class;
}
