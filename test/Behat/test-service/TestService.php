<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-service
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\Service\Behat\Test\Service;

use OldTown\Workflow\ZF2\Service\Annotation as WFS;


/**
 * Class TestService
 *
 * @package OldTown\Workflow\ZF2\Service\Behat\Test\Service
 */
class TestService
{
    /**
     * Тестовй сервис
     *
     * @WFS\ArgumentsMap(argumentsMap={
     *      @WFS\Map(fromArgName="argName1AliasSource", to="testArgName1"),
     *      @WFS\Map(fromArgName="argName2AliasSource", to="testArgName2"),
     *})
     * @WFS\ResultsMap(map={
     *      @WFS\ResultMap(from="fromResult1", to="result1", override=false),
     *      @WFS\ResultMap(from="fromResult2", to="result2", override=false)
     * })
     * @WFS\ResultVariable(name="testResultVariableName", override="false")
     *
     * @param $testArgName1
     * @param $testArgName2
     *
     * @return array
     */
    public function dispatch($testArgName1, $testArgName2)
    {
        return [
            'fromResult1' => 'test_result_value1' . $testArgName1,
            'fromResult2' => 'test_result_value2' . $testArgName2,
        ];
    }
}
