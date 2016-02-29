<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Storage;

/**
 * Class Metadata
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Storage
 */
class Metadata implements MetadataInterface
{
    /**
     * Имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @var string|null
     */
    protected $resultVariableName;

    /**
     * Определяет можно ли перетирать уже существующую переменную
     *
     * @var bool
     */
    protected $allowOverrideResult = false;

    /**
     * Флаг определяет используется ли маппинг результатов
     *
     * @var bool
     */
    protected $flagUseResultMap = false;

    /**
     * Карта для наложения результатов работы сервиса в TransientVars
     *
     * @var array
     */
    protected $resultMap = [];

    /**
     * Хеши обеспечивающие уникальность данных используемых для маппинга результатов работы сервиса
     *
     * @var array
     */
    protected $resultMapHash = [];

    /**
     * Имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @return string|null
     */
    public function getResultVariableName()
    {
        return $this->resultVariableName;
    }

    /**
     * Устанавливает имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @param string $resultVariableName
     *
     * @return $this
     */
    public function setResultVariableName($resultVariableName)
    {
        $this->resultVariableName = (string)$resultVariableName;

        return $this;
    }

    /**
     * Определяет можно ли перетирать уже существующую переменную
     *
     * @return boolean
     */
    public function isAllowOverrideResult()
    {
        return $this->allowOverrideResult;
    }

    /**
     * Определяет можно ли перетирать уже существующую переменную
     *
     * @param boolean $allowOverrideResult
     *
     * @return $this
     */
    public function setAllowOverrideResult($allowOverrideResult)
    {
        $this->allowOverrideResult = (boolean)$allowOverrideResult;

        return $this;
    }

    /**
     * Флаг определяет используется ли маппинг результатов
     *
     * @return boolean
     */
    public function getFlagUseResultMap()
    {
        return $this->flagUseResultMap;
    }

    /**
     * Добавляет информацию о маппинге результатов работы функции
     *
     * @param ResultMapMetadataInterface $item
     *
     * @return $this
     *
     * @throws Exception\InvalidResultMapException
     */
    public function addResultMap(ResultMapMetadataInterface $item)
    {
        $key = $item->getFrom() . '_' . $item->getTo();
        if (array_key_exists($key, $this->resultMapHash)) {
            $errMsg = sprintf('Map for key %s already exists', $key);
            throw new Exception\InvalidResultMapException($errMsg);
        }


        $this->resultMap[$item->getFrom()] = $item;
        $this->resultMapHash[$key] = $key;
        $this->flagUseResultMap = true;

        return $this;
    }

    /**
     * Определеяет, есть ля для результата с именем "from" данные для наложения на transientVars
     *
     * @param $from
     *
     * @return boolean
     */
    public function hasResultMap($from)
    {
        return array_key_exists($from, $this->resultMap);
    }


    /**
     * Возвращает данные для маппинга результатов
     *
     * @param $from
     *
     * @return ResultMapMetadataInterface
     *
     * @throws Exception\InvalidResultMapException
     */
    public function getResultMapByFrom($from)
    {
        if (!$this->hasResultMap($from)) {
            $errMsg = sprintf('Map for key %s not found', $from);
            throw new Exception\InvalidResultMapException($errMsg);
        }
        return $this->resultMap[$from];
    }
}
