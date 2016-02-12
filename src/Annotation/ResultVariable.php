<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class ResultVariableName
 *
 * @package OldTown\Workflow\ZF2\Service\Annotation
 *
 * @Annotation
 * @Target({"METHOD"})
 */
final class ResultVariable
{
    /**
     * Имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @var string
     *
     * @Required()
     */
    public $name;

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @var string
     *
     */
    public $override = false;
}
