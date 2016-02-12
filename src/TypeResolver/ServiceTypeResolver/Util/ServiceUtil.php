<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util;

use OldTown\Workflow\TransientVars\TransientVarsInterface;
use ReflectionObject;
use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;

/**
 * Class ServiceUtil
 *
 * @package OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util
 */
class ServiceUtil implements ServiceUtilInterface
{
    /**
     * @var array
     */
    protected static $listArgumentForMethodCache = [];

    /**
     * @param callable $service
     *
     * @throws Exception\UnsupportedServiceTypeException
     * @return array
     */
    public function getListArgumentForService(callable $service)
    {
        if (is_array($service)) {
            reset($service);
            $serviceObject = current($service);
            $serviceMethod = next($service);
            return $this->getListArgumentForMethod($serviceObject, $serviceMethod);
        }

        $errMsg = 'Unsupported type callback';
        throw new Exception\UnsupportedServiceTypeException($errMsg);
    }

    /**
     * Получение сигнарутры метод
     *
     *
     * @param mixed $serviceObject
     * @param string $serviceMethod
     *
     * @return array
     */
    protected function getListArgumentForMethod($serviceObject, $serviceMethod)
    {
        $key = get_class($serviceObject) . '--' . $serviceMethod;

        if (array_key_exists($key, static::$listArgumentForMethodCache)) {
            return static::$listArgumentForMethodCache[$key];
        }

        $r = new ReflectionObject($serviceObject);
        $rParameters = $r->getMethod($serviceMethod)->getParameters();

        $arguments = [];
        foreach ($rParameters as $rParameter) {
            $position = $rParameter->getPosition();

            $arguments[$position] = [
                'name' => $rParameter->getName(),
                'defaultValue' => $rParameter->isDefaultValueAvailable() ? $rParameter->getDefaultValue() : null
            ];
        }

        ksort($arguments, SORT_NUMERIC);

        $listArgument = [];
        foreach ($arguments as $argument) {
            $listArgument[$argument['name']] = $argument['defaultValue'];
        }

        return $listArgument;
    }

    /**
     * Подготавливает список аргументов, для вызова сервиса
     *
     * @param callable               $service
     * @param MetadataInterface      $metadata
     * @param TransientVarsInterface $transientVars
     * @param array                  $args
     *
     * @return array
     *
     * @throws \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver\Util\Exception\UnsupportedServiceTypeException
     * @throws Exception\FunctionArgumentNotFoundException
     * @throws Exception\ArgumentNotFoundInTransientVarsException
     */
    public function buildArgumentsForService(callable $service, MetadataInterface $metadata, TransientVarsInterface $transientVars, array $args = [])
    {
        $listArgument = $this->getListArgumentForService($service);

        $argumentsMap = $metadata->getArgumentsMap();

        $listMapArguments = array_values($argumentsMap);
        $listUniqueMapArguments = array_unique($listMapArguments);

        $argsName = array_keys($args);

        $diff = array_diff($listUniqueMapArguments, $argsName);
        if (0 !== count($diff)) {
            $errMsg = sprintf('There are no arguments with names: %s', implode($diff));
            throw new Exception\FunctionArgumentNotFoundException($errMsg);
        }


        $arguments = [];
        foreach ($listArgument as $name => $defaultValue) {
            if (array_key_exists($name, $argumentsMap)) {
                $argName = $argumentsMap[$name];
                $key = $args[$argName];

                if (!$transientVars->offsetExists($key)) {
                    $errMsg = sprintf('Argument "%s" not found in transientVars', $key);
                    throw new Exception\ArgumentNotFoundInTransientVarsException($errMsg);
                }
                $arguments[$name] = $transientVars[$key];
                continue;
            }

            if ($transientVars->offsetExists($name)) {
                $arguments[$name] = $transientVars[$name];
                continue;
            }

            if (array_key_exists($name, $args)) {
                $arguments[$name] = $args[$name];
                continue;
            }

            $arguments[$name] = $defaultValue;
        }

        return $arguments;
    }
}
