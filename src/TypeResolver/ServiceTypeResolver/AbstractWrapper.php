<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util\ServiceUtil;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util\ServiceUtilInterface;

/**
 * Class AbstractWrapper
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver
 */
abstract class AbstractWrapper implements WrapperInterface
{
    /**
     * @var callable
     */
    protected $service;

    /**
     * @var ServiceUtilInterface
     */
    protected static $serviceUtil;

    /**
     * @param callable $service
     */
    public function __construct(callable $service)
    {
        $this->service = $service;
    }

    /**
     * @return callable
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return ServiceUtilInterface
     */
    public static function getServiceUtil()
    {
        if (null === static::$serviceUtil) {
            static::$serviceUtil = new ServiceUtil();
        }
        return static::$serviceUtil;
    }

    /**
     * @param ServiceUtilInterface $serviceUtil
     */
    public static function setServiceUtil(ServiceUtilInterface $serviceUtil)
    {
        static::$serviceUtil = $serviceUtil;
    }
}
