<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver;

use OldTown\Workflow\ConditionInterface;
use OldTown\Workflow\FunctionProviderInterface;
use OldTown\Workflow\RegisterInterface;
use OldTown\Workflow\TypeResolverInterface;
use OldTown\Workflow\ValidatorInterface;
use OldTown\Workflow\ZF2\Service\Service\Manager;
use OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\WrapperInterface;

/**
 * Class ManagerFactory
 *
 * @package OldTown\Workflow\ZF2\Service\Service
 */
class ServiceTypeResolver implements TypeResolverInterface
{
    /**
     * @var string
     */
    const SERVICE_TYPE = 'service';

    /**
     *
     * @var string
     */
    const SERVICE_NAME = 'serviceName';

    /**
     * @var string
     */
    const SERVICE_METHOD = 'serviceMethod';

    /**
     * @var Manager
     */
    protected $workflowServiceManager;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        call_user_func_array([$this, 'init'], $options);
    }

    /**
     * @param Manager $serviceManager
     */
    protected function init(Manager $serviceManager)
    {
        $this->workflowServiceManager = $serviceManager;
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return ValidatorInterface
     *
     * @throws Exception\ErrorCreatingValidatorException
     */
    public function getValidator($type, array $args = [])
    {
        try {
            $wrapper = $this->wrapperFactory($type, $args, ServiceTypeResolver\ValidatorWrapper::class);
        } catch (\Exception $e) {
            throw new Exception\ErrorCreatingValidatorException($e->getMessage(), $e->getCode(), $e);
        }
        return $wrapper;
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return RegisterInterface
     *
     * @throws Exception\ErrorCreatingRegisterException
     */
    public function getRegister($type, array $args = [])
    {
        try {
            $wrapper = $this->wrapperFactory($type, $args, ServiceTypeResolver\RegisterWrapper::class);
        } catch (\Exception $e) {
            throw new Exception\ErrorCreatingRegisterException($e->getMessage(), $e->getCode(), $e);
        }
        return $wrapper;
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return FunctionProviderInterface|null
     *
     * @throws Exception\ErrorCreatingFunctionException
     */
    public function getFunction($type, array $args = [])
    {
        try {
            $wrapper = $this->wrapperFactory($type, $args, ServiceTypeResolver\FunctionWrapper::class);
        } catch (\Exception $e) {
            throw new Exception\ErrorCreatingFunctionException($e->getMessage(), $e->getCode(), $e);
        }
        return $wrapper;
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return ConditionInterface
     *
     * @throws Exception\ErrorCreatingConditionException
     */
    public function getCondition($type, array $args = [])
    {
        try {
            $wrapper = $this->wrapperFactory($type, $args, ServiceTypeResolver\ConditionWrapper::class);
        } catch (\Exception $e) {
            throw new Exception\ErrorCreatingConditionException($e->getMessage(), $e->getCode(), $e);
        }
        return $wrapper;
    }

    /**
     * @return Manager
     */
    public function getWorkflowServiceManager()
    {
        return $this->workflowServiceManager;
    }

    /**
     * @param       $type
     * @param array $args
     * @param       $classWrapper
     *
     * @return WrapperInterface|null
     *
     * @throws Exception\InvalidServiceNameException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Zend\ServiceManager\Exception\ServiceNotCreatedException
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     * @throws Exception\InvalidServiceException
     */
    protected function wrapperFactory($type, array $args = [], $classWrapper)
    {
        if (static::SERVICE_TYPE !== $type) {
            return null;
        }

        if (!array_key_exists(static::SERVICE_NAME, $args)) {
            $errMsg = sprintf('Argument %s not found', static::SERVICE_NAME);
            throw new Exception\InvalidServiceNameException($errMsg);
        }
        $serviceName = $args[static::SERVICE_NAME];

        if (!array_key_exists(static::SERVICE_METHOD, $args)) {
            $errMsg = sprintf('Argument %s not found', static::SERVICE_METHOD);
            throw new Exception\InvalidServiceNameException($errMsg);
        }
        $serviceMethod = $args[static::SERVICE_METHOD];

        $service = $this->getWorkflowServiceManager()->get($serviceName);
        $serviceCallback = [$service, $serviceMethod];

        if (!is_callable($serviceCallback)) {
            $errMsg = sprintf('Service name %s and method %s', $serviceName, $serviceMethod);
            throw new Exception\InvalidServiceException($errMsg);
        }

        $r = new \ReflectionClass($classWrapper);
        $wrapper = $r->newInstanceArgs([
            'service' => $serviceCallback
        ]);

        return $wrapper;
    }
}
