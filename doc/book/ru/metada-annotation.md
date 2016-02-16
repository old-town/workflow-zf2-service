# Метаданные на основе анотаций для маппинга аргументов и результатов сервиса.

Для использования анотаций, необходимо в use декларировать использование пространства имен OldTown\Workflow\ZF2\Service\Annotation.
Рекомендовано использовать псевдоним WFS(WorkFlowService).

В дальнейшем при упоминание конкретных анотаций, имеется в виду что они определены в пространстве имен OldTown\Workflow\ZF2\Service\Annotation.

Workflow XML:
```xml
<workflow>
    <registers>
        <register type="phpshell" variable-name="testVariable1">
            <arg name="script">return "test_value1";</arg>
        </register>
        <register type="phpshell" variable-name="testVariable2">
            <arg name="script">return "test_value2";</arg>
        </register>
    </registers>
    <initial-actions>
        <action id="100" name="StartWorkflow">
            <pre-functions>
                <function type="service">
                    <arg name="serviceName">\OldTown\Workflow\ZF2\Service\Behat\Test\Service\TestService</arg>
                    <arg name="serviceMethod">dispatch</arg>
                    <arg name="argName1AliasSource">testVariable1</arg>
                    <arg name="argName2AliasSource">testVariable2</arg>
                </function>
            </pre-functions>
            <results>
                <unconditional-result old-status="Finished" status="Underway" step="2"/>
            </results>
        </action>
    </initial-actions>
    <steps>
        <step id="2" name="First Draft">
            <actions>
                <action id="811" name="Finish_First_Draft">
                    <results>
                        <unconditional-result old-status="Finished" status="Underway"  step="2"/>
                    </results>
                </action>
            </actions>
        </step>
    </steps>
</workflow>
```

Код сервиса:
```php
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
```

## Маппинг аргументов.

Для мапинга аргументов используется анотация ArgumentsMap. Она содержит одно значение argumentsMap - массив из анотаций Map.
Описание анотации Map

Название параметра|Обязательный|Описание           
------------------|------------|---------------------------------------------------------------------
fromArgName       |Да          |Имя аргумента функции(тег arg, внутри тега function в workflow), значение которого определяет ключ($key) в TransientVars. TransientVars[$key] - то значение которое передается в качестве аргумента сервису
to                |Да          |Имя аргумента сервиса

В вышеприведенном примере с помощью register, происходит установка значение в TransientVars:
 * TransientVars[testVariable1] = test_value1
 * TransientVars[testVariable2] = test_value2
 
С помощью метаданных мы указываем, что для получения значения $testArgName1 в \OldTown\Workflow\ZF2\Service\Behat\Test\Service\TestService::dispatch
```php
@WFS\ArgumentsMap(argumentsMap={
    @WFS\Map(fromArgName="argName1AliasSource", to="testArgName1")
})
```
Мы считываем аргумент функции с именем argName1AliasSource
```xml
<arg name="argName1AliasSource">testVariable1</arg>
```
Берем значение этого аргумента - testVariable1. И ожидаем что в TransientVars, есть TransientVars['testVariable1].
Таким образом в вышеприведенном примере в testVariable1, будет переданно значение test_value1.

## Маппинг результатов ResultVariable и ResultsMap. Эти анотации могут использоваться как по отдельности, так и вместе. 

Маппинг результатов происходит с помощью анотаций 

### Сохранение результатов в одну переменную (ResultVariable)





