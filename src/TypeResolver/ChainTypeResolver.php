<?php
/**
 * @link https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\TypeResolver;

use OldTown\Workflow\ConditionInterface;
use OldTown\Workflow\FunctionProviderInterface;
use OldTown\Workflow\RegisterInterface;
use OldTown\Workflow\TypeResolverInterface;
use OldTown\Workflow\ValidatorInterface;
use SplPriorityQueue;

/**
 * Class ManagerFactory
 *
 * @package OldTown\Workflow\ZF2\ServiceEngine\Service
 */
class ChainTypeResolver implements ChainTypeResolverInterface
{
    /**
     * @var SplPriorityQueue|TypeResolverInterface[]
     */
    protected $chain;

    /**
     * Флаг определяет нужно ли игнорировать исключения бросаемые резолверами
     *
     * @var bool
     */
    protected $flagIgnoreException = false;

    /**
     * Chain constructor.
     *
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @return void
     */
    protected function init()
    {
        $this->chain = new SplPriorityQueue();
        $this->chain->setExtractFlags(SplPriorityQueue::EXTR_DATA);
    }

    /**
     * @param TypeResolverInterface $resolver
     * @param int                   $priority
     *
     * @return $this
     */
    public function add(TypeResolverInterface $resolver, $priority = 1)
    {
        $this->chain->insert($resolver, $priority);

        return $this;
    }


    /**
     * @param string $type
     * @param array  $args
     *
     * @return ValidatorInterface
     *
     * @throws Exception\RuntimeException
     * @throws Exception\ResultNotFoundException
     */
    public function getValidator($type, array $args = [])
    {
        while ($this->chain->valid()) {
            /** @var TypeResolverInterface $resolver */
            $resolver = $this->chain->current();
            try {
                $validator = $resolver->getValidator($type, $args);
                if ($validator instanceof ValidatorInterface) {
                    return $validator;
                }
            } catch (\Exception $e) {
                if (!$this->getFlagIgnoreException()) {
                    throw new Exception\RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            }
            $this->chain->next();
        }

        $errMsg = sprintf('Validator for type %s not found', $type);
        throw new Exception\ResultNotFoundException($errMsg);
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return RegisterInterface
     *
     * @throws Exception\ResultNotFoundException
     * @throws Exception\RuntimeException
     */
    public function getRegister($type, array $args = [])
    {
        while ($this->chain->valid()) {
            /** @var TypeResolverInterface $resolver */
            $resolver = $this->chain->current();
            try {
                $register = $resolver->getRegister($type, $args);
                if ($register instanceof RegisterInterface) {
                    return $register;
                }
            } catch (\Exception $e) {
                if (!$this->getFlagIgnoreException()) {
                    throw new Exception\RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            }
            $this->chain->next();
        }

        $errMsg = sprintf('Register for type %s not found', $type);
        throw new Exception\ResultNotFoundException($errMsg);
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return FunctionProviderInterface
     *
     * @throws Exception\RuntimeException
     * @throws Exception\ResultNotFoundException
     */
    public function getFunction($type, array $args = [])
    {
        while ($this->chain->valid()) {
            /** @var TypeResolverInterface $resolver */
            $resolver = $this->chain->current();
            try {
                $function = $resolver->getFunction($type, $args);
                if ($function instanceof FunctionProviderInterface) {
                    return $function;
                }
            } catch (\Exception $e) {
                if (!$this->getFlagIgnoreException()) {
                    throw new Exception\RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            }
            $this->chain->next();
        }

        $errMsg = sprintf('Function for type %s not found', $type);
        throw new Exception\ResultNotFoundException($errMsg);
    }

    /**
     * @param string $type
     * @param array  $args
     *
     * @return FunctionProviderInterface
     *
     * @throws Exception\ResultNotFoundException
     * @throws Exception\RuntimeException
     */
    public function getCondition($type, array $args = [])
    {
        while ($this->chain->valid()) {
            /** @var TypeResolverInterface $resolver */
            $resolver = $this->chain->current();
            try {
                $condition = $resolver->getCondition($type, $args);
                if ($condition instanceof ConditionInterface) {
                    return $condition;
                }
            } catch (\Exception $e) {
                if (!$this->getFlagIgnoreException()) {
                    throw new Exception\RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            }
            $this->chain->next();
        }

        $errMsg = sprintf('Condition for type %s not found', $type);
        throw new Exception\ResultNotFoundException($errMsg);
    }

    /**
     * @return boolean
     */
    public function getFlagIgnoreException()
    {
        return $this->flagIgnoreException;
    }

    /**
     * @param boolean $flagIgnoreException
     *
     * @return $this
     */
    public function setFlagIgnoreException($flagIgnoreException)
    {
        $this->flagIgnoreException = (boolean)$flagIgnoreException;

        return $this;
    }
}
