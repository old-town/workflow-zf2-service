<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;

/**
 * Interface WrapperInterface
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver
 */
interface WrapperInterface
{
    /**
     * @param callable        $service
     * @param MetadataInterface $metadata
     */
    public function __construct(callable $service, MetadataInterface $metadata);

    /**
     * @return callable
     */
    public function getService();
}
