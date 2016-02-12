<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver;

use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util\ServiceUtil;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util\ServiceUtilInterface;
use ReflectionClass;
use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;



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
     * Набор утилит для запуска сервисов workflow
     *
     * @var ServiceUtilInterface
     */
    protected $serviceUtil;

    /**
     * Имя класса, реалузующего набор утилит для запуска сервисов workflow
     *
     * @var string
     */
    protected $serviceUtilClassName = ServiceUtil::class;

    /**
     * Метаданные сервиса
     *
     * @var MetadataInterface
     */
    protected $metadata;

    /**
     * @param callable          $service
     * @param MetadataInterface $metadata
     */
    public function __construct(callable $service, MetadataInterface $metadata)
    {
        $this->service = $service;
        $this->metadata = $metadata;
    }

    /**
     * @return callable
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Метаданные сервиса
     *
     * @return MetadataInterface
     */
    public function getMetadata()
    {
        return $this->metadata;
    }


    /**
     * Набор утилит для запуска сервисов workflow
     *
     * @return ServiceUtilInterface
     *
     * @throws Exception\RuntimeException
     */
    public function getServiceUtil()
    {
        if ($this->serviceUtil) {
            return $this->serviceUtil;
        }

        $className = $this->getServiceUtilClassName();
        $r = new ReflectionClass($className);
        $instance = $r->newInstance();

        if (!$instance instanceof ServiceUtilInterface) {
            $errMsg = sprintf('Service util not implement %s', ServiceUtilInterface::class);
            throw new Exception\RuntimeException($errMsg);
        }
        $this->serviceUtil = $instance;

        return $this->serviceUtil;
    }

    /**
     * Устанавливает набор утилит для запуска сервисов workflow
     *
     * @param ServiceUtilInterface $serviceUtil
     *
     * @return $this
     */
    public function setServiceUtil(ServiceUtilInterface $serviceUtil)
    {
        $this->serviceUtil = $serviceUtil;
        $this->serviceUtilClassName = get_class($serviceUtil);

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceUtilClassName()
    {
        return $this->serviceUtilClassName;
    }

    /**
     * @param string $serviceUtilClassName
     *
     * @return $this
     */
    public function setServiceUtilClassName($serviceUtilClassName)
    {
        $this->serviceUtilClassName = (string)$serviceUtilClassName;
        $this->serviceUtil = null;

        return $this;
    }
}
