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
