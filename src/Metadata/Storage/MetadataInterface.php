<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Storage;

/**
 * Interface MetadataInterface
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Storage
 */
interface MetadataInterface
{
    /**
     * Имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @return string|null
     */
    public function getResultVariableName();

    /**
     * Устанавливает имя переменной в transientVars, в которую нужно сохранить результаты сервиса
     *
     * @param string $resultVariableName
     *
     * @return $this
     */
    public function setResultVariableName($resultVariableName);

    /**
     * Определяет можно ли перетирать уже существующую переменную
     *
     * @return boolean
     */
    public function isAllowOverrideResult();

    /**
     * @param boolean $allowOverrideResult
     *
     * @return $this
     */
    public function setAllowOverrideResult($allowOverrideResult);

    /**
     * Флаг определяет используется ли маппинг результатов
     *
     * @return boolean
     */
    public function getFlagUseResultMap();

    /**
     * Добавляет информацию о маппинге результатов работы функции
     *
     * @param ResultMapMetadataInterface $item
     *
     * @return $this
     *
     */
    public function addResultMap(ResultMapMetadataInterface $item);


    /**
     * Определеяет, есть ля для результата с именем "from" данные для наложения на transientVars
     *
     * @param $from
     *
     * @return boolean
     */
    public function hasResultMap($from);


    /**
     * Возвращает данные для маппинга результатов
     *
     * @param $from
     *
     * @return ResultMapMetadataInterface
     *
     */
    public function getResultMapByFrom($from);
}
