<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace  OldTown\Workflow\ZF2\Service\Listener\Exception;

use OldTown\Workflow\ZF2\Service\Exception\InvalidArgumentException as Exception;

/**
 * Class InvalidArgumentException
 *
 * @package OldTown\Workflow\ZF2\Service\Listener\Exception
 */
class InvalidArgumentException extends Exception implements
    ExceptionInterface
{
}
