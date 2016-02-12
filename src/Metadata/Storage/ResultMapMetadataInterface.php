<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Storage;

/**
 * Interface ResultMapMetadataInterface
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Storage
 */
interface ResultMapMetadataInterface
{
    /**
     * Указывает имя из результав работы сервиса
     *
     * @return string
     */
    public function getFrom();

    /**
     * Определяет имя переменной из результатов работы сервиса, которое необходимо сохранить в TransientVars
     *
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from);

    /**
     * Имя переменной в TransientVars
     *
     * @return string
     */
    public function getTo();

    /**
     * Устанавливает имя переменной в TransientVars
     *
     * @param string $to
     *
     * @return $this
     */
    public function setTo($to);

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @return boolean
     */
    public function getOverride();

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @param boolean $override
     *
     * @return $this
     */
    public function setOverride($override);
}
