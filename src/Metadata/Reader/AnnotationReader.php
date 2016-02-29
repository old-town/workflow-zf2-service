<?php
/**
 * @link https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Metadata\Reader;

use OldTown\Workflow\ZF2\Service\Metadata\Storage\MetadataInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader as DoctrineAnnotationsReaderInterface;
use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use OldTown\Workflow\ZF2\Service\Metadata\Storage\Metadata;
use ReflectionClass;
use OldTown\Workflow\ZF2\Service\Annotation;
use OldTown\Workflow\ZF2\Service\Metadata\Storage\ResultMapMetadata;

/**
 * Class AnnotationReader
 *
 * @package OldTown\Workflow\ZF2\Service\Metadata\Reader
 */
class AnnotationReader implements ReaderInterface
{
    /**
     * @var string
     */
    const READER_NAME = 'annotation';

    /**
     * @var DoctrineAnnotationsReaderInterface
     */
    protected $reader;

    /**
     * Имя класса адаптера для чтения анотаций
     *
     * @var string
     */
    protected $doctrineAnnotationReaderClassName = DoctrineAnnotationReader::class;

    /**
     * Кеш загруженных метаданных
     *
     * @var MetadataInterface[]
     */
    protected $classAnnotations = [];

    /**
     *
     * @throws Exception\AnnotationReaderException
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Иницилазия
     *
     * @return void
     * @throws Exception\AnnotationReaderException
     */
    protected function init()
    {
        try {
            AnnotationRegistry::registerLoader(function ($class) {
                return (bool) class_exists($class);
            });
        } catch (\Exception $e) {
            throw new Exception\AnnotationReaderException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Получение метаданных для сервиса, по имени класса сервиса и вызываемому методу
     *
     * @param string  $serviceClassName
     * @param  string $serviceMethod
     *
     * @return MetadataInterface
     *
     * @throws Exception\AnnotationReaderException
     *
     * @throws \OldTown\Workflow\ZF2\Service\Metadata\Reader\Exception\InvalidDoctrineAnnotationsReaderException
     * @throws \OldTown\Workflow\ZF2\Service\Metadata\Storage\Exception\InvalidArgumentMapException
     * @throws Exception\InvalidMetadataException
     * @throws \OldTown\Workflow\ZF2\Service\Metadata\Storage\Exception\InvalidResultMapException
     */
    public function loadMetadataForClassService($serviceClassName, $serviceMethod)
    {
        $key = $serviceClassName . '_' . $serviceMethod;
        if (array_key_exists($key, $this->classAnnotations)) {
            return $this->classAnnotations[$key];
        }

        $r = new ReflectionClass($serviceClassName);
        $rMethod = $r->getMethod($serviceMethod);

        $metadata = new Metadata();

        /** @var Annotation\ResultVariable|null $resultVariableAnnotation */
        $resultVariableAnnotation = $this->getReader()->getMethodAnnotation($rMethod, Annotation\ResultVariable::class);
        if (null !== $resultVariableAnnotation) {
            $metadata->setResultVariableName($resultVariableAnnotation->name);
            $metadata->setAllowOverrideResult($resultVariableAnnotation->override);
        }

        /** @var Annotation\ResultsMap|null $resultsMapAnnotation */
        $resultsMapAnnotation = $this->getReader()->getMethodAnnotation($rMethod, Annotation\ResultsMap::class);
        if (null !== $resultsMapAnnotation && is_array($resultsMapAnnotation->map) && count($resultsMapAnnotation->map) > 0) {
            foreach ($resultsMapAnnotation->map as $resultMap) {
                if (!$resultMap instanceof  Annotation\ResultMap) {
                    $errMsg = sprintf('Result map not implements %s', Annotation\ResultMap::class);
                    throw new Exception\InvalidMetadataException($errMsg);
                }

                $resultMap = new ResultMapMetadata($resultMap->from, $resultMap->to, $resultMap->override);
                $metadata->addResultMap($resultMap);
            }
        }

        return $metadata;
    }

    /**
     * @return DoctrineAnnotationsReaderInterface
     *
     * @throws Exception\InvalidDoctrineAnnotationsReaderException
     */
    public function getReader()
    {
        if ($this->reader) {
            return $this->reader;
        }

        $className = $this->getDoctrineAnnotationReaderClassName();

        $r = new ReflectionClass($className);

        $instance = $r->newInstance();

        if (!$instance instanceof DoctrineAnnotationsReaderInterface) {
            $errMsg = sprintf('Reader not implement %s', DoctrineAnnotationsReaderInterface::class);
            throw new Exception\InvalidDoctrineAnnotationsReaderException($errMsg);
        }

        $this->reader = $instance;

        return $this->reader;
    }

    /**
     * @param DoctrineAnnotationsReaderInterface $reader
     *
     * @return $this
     */
    public function setReader(DoctrineAnnotationsReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Имя класса адаптера для чтения анотаций
     *
     * @return string
     */
    public function getDoctrineAnnotationReaderClassName()
    {
        return $this->doctrineAnnotationReaderClassName;
    }

    /**
     * Устанавливает имя класса адаптера для чтения анотаций
     *
     * @param string $doctrineAnnotationReaderClassName
     *
     * @return $this
     */
    public function setDoctrineAnnotationReaderClassName($doctrineAnnotationReaderClassName)
    {
        $this->doctrineAnnotationReaderClassName = (string)$doctrineAnnotationReaderClassName;

        return $this;
    }
}
