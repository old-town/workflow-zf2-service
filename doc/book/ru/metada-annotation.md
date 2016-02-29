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
                    <arg name="testArgName1">${testVariable1}</arg>
                    <arg name="testArgName2">${testVariable2}</arg>
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


## Маппинг результатов ResultVariable и ResultsMap. Эти анотации могут использоваться как по отдельности, так и вместе. 

Маппинг результатов происходит с помощью анотаций 

### Сохранение результатов в одну переменную (ResultVariable)

Сохранение результатов работы сервиса в TransientVars происходит с помощоью анотации ResultVariable. Описание ее 
параметров:

Название параметра|Обязательный|Значение по умолчанию|Описание           
------------------|------------|---------------------|---------------------------------------------------------------------
name              |Да          |                     |Имя ключа в TransientVars
override          |Нет         |false                |Определяет можно ли перетирать в TransientVars существующие значения


### Наложение результатов из массив.
Если сервис возвращает массив. То данные могут бы наложены на TransientVars. При этом с помощью анотаций, можно описать
карту соответсвтий, между ключаем массив, и ключами TransientVars.

Для описания карты соответствий используется анотация ResultsMap, она содериж одно свойство - map, представляющее из
себя коллекцию анотаций ResultMap.

Описание анотации ResultsMap:
Название параметра|Обязательный|Значение по умолчанию|Описание           
------------------|------------|---------------------|---------------------------------------------------------------------
from              |Да          |                     |Имя ключа в массиве результатов, который вернул сервис
to                |Да          |                     |Имя ключа в TransientVars
override          |Нет         |false                |Определяет можно ли перетирать в TransientVars существующие значения


