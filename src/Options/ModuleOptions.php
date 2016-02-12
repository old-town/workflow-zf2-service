<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package OldTown\Workflow\ZF2\Service\Options
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Имя класса менеджера для работы с метаданными сервисов
     *
     * @var string
     */
    protected $metadataReaderManagerClassName;

    /**
     * Имя адапетра для чтения метаданных
     *
     * @var string
     */
    protected $metadataReader;

    /**
     * Имя адапетра для чтения метаданных
     *
     * @var array
     */
    protected $metadataReaderOptions;

    /**
     * Имя класса менеджера для работы с метаданными сервисов
     *
     * @return string
     */
    public function getMetadataReaderManagerClassName()
    {
        return $this->metadataReaderManagerClassName;
    }

    /**
     * Устанавливает имя класса менеджера для работы с метаданными сервисов
     *
     * @param string $metadataReaderManagerClassName
     *
     * @return $this
     */
    public function setMetadataReaderManagerClassName($metadataReaderManagerClassName)
    {
        $this->metadataReaderManagerClassName = $metadataReaderManagerClassName;

        return $this;
    }

    /**
     * Имя адапетра для чтения метаданных
     *
     * @return string
     */
    public function getMetadataReader()
    {
        return $this->metadataReader;
    }

    /**
     * Устанавливает имя адапетра для чтения метаданных
     *
     * @param string $metadataReader
     *
     * @return $this
     */
    public function setMetadataReader($metadataReader)
    {
        $this->metadataReader = $metadataReader;

        return $this;
    }

    /**
     * @return array
     */
    public function getMetadataReaderOptions()
    {
        return $this->metadataReaderOptions;
    }

    /**
     * @param array $metadataReaderOptions
     *
     * @return $this
     */
    public function setMetadataReaderOptions(array $metadataReaderOptions = [])
    {
        $this->metadataReaderOptions = $metadataReaderOptions;

        return $this;
    }
}
