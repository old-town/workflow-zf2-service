<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver;

use OldTown\Workflow\TypeResolverInterface;


/**
 * Class ManagerFactory
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Service
 */
interface ChainTypeResolverInterface extends TypeResolverInterface
{
    /**
     * @param TypeResolverInterface $resolver
     * @param int                   $priority
     *
     * @return $this
     */
    public function add(TypeResolverInterface $resolver, $priority = 1);


    /**
     * @return boolean
     */
    public function getFlagIgnoreException();

    /**
     * @param boolean $flagIgnoreException
     *
     * @return $this
     */
    public function setFlagIgnoreException($flagIgnoreException);
}
