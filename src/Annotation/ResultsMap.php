<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;


/**
 * Class ResultsMap
 *
 * @package OldTown\Workflow\ZF2\Service\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
final class ResultsMap
{
    /**
     * @var array<\OldTown\Workflow\ZF2\Service\Annotation\ResultMap>
     *
     * @Required()
     */
    public $map = [];
}
