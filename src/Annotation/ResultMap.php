<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;


/**
 * Class ResultMap
 *
 * @package OldTown\Workflow\ZF2\Service\Annotation
 *
 * @Annotation
 * @Target("ANNOTATION")
 */
final class ResultMap
{
    /**
     * Указывает имя из результав работы сервиса
     *
     * @var string
     *
     * @Required()
     */
    public $from;

    /**
     * Имя переменной в TransientVars
     *
     * @var string
     *
     * @Required()
     */
    public $to;

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @var boolean
     *
     */
    public $override = false;
}
