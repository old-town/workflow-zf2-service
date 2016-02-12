<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class Map
 *
 * @package OldTown\Workflow\ZF2\Service\Annotation
 *
 * @Annotation
 * @Target("ANNOTATION")
 */
final class Map
{
    /**
     * Указывает имя аргумента. Значение которого определяет имя, по которому будет получаться значение из TransientVars
     *
     * @var string
     *
     * @Required()
     */
    public $fromArgName;

    /**
     * Имя аргумента сервиса
     *
     * @var string
     *
     * @Required()
     */
    public $to;
}
