<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Storage;

/**
 * Class ResultMapMetadata
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Storage
 */
class ResultMapMetadata implements ResultMapMetadataInterface
{
    /**
     * Указывает имя из результав работы сервиса
     *
     * @var string
     *
     */
    protected $from;

    /**
     * Имя переменной в TransientVars
     *
     * @var string
     *
     */
    protected $to;

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @var boolean
     *
     */
    protected $override = false;

    /**
     * ResultMapMetadata constructor.
     *
     * @param string $from
     * @param string $to
     * @param boolean $override
     */
    public function __construct($from, $to, $override)
    {
        $this->setFrom($from);
        $this->setTo($to);
        $this->setOverride($override);
    }

    /**
     * Указывает имя из результав работы сервиса
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Определяет имя переменной из результатов работы сервиса, которое необходимо сохранить в TransientVars
     *
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Имя переменной в TransientVars
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Устанавливает имя переменной в TransientVars
     *
     * @param string $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @return boolean
     */
    public function getOverride()
    {
        return $this->override;
    }

    /**
     * Разрешает перетирать ужу существующее значение
     *
     * @param boolean $override
     *
     * @return $this
     */
    public function setOverride($override)
    {
        $this->override = (boolean)$override;

        return $this;
    }
}
