<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Behat\Test\Service;

/**
 * Class CallbackService
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Behat\Test\Service
 */
class CallbackService
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     *
     * @return void
     */
    public function dispatch()
    {
        call_user_func_array($this->getCallback(), func_get_args());
    }
}
