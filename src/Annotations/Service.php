<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class Service
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Annotations
 *
 * @Annotation
 * @Target("CLASS")
 */
class Service
{
    /**
     * @var string
     */
    public $name;

    /**
     * @Enum({"validator", "condition", "register", "function"})
     * @Required
     */
    public $type;
}
