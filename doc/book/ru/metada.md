# Метаданные для сервисов

При запуске workflow создается объект имплементирующий \OldTown\Workflow\TransientVars\TransientVarsInterface.
Этот объект является промежуточным хранилищем результатов работы функции(Function) workflow. Также этот объект 
содержит данные подготовленные для wf(концепия слоев описана в old-town/workflow-zf2-dispatch).

Во время работы wf могут вызываться функции(Function), условия(Condition), валидаторы(Validator), регистры(Register).
Данный модуль делегирует обработку таких вызовов "сервису". По факту сервис представляет из себя вызов метода
определенного объекта.

Система спроектированна таким образом, что сервисы ничего не знают o workflow. Это дает большую гибкость при написание
тестов для сервисов, а также уменьшает связанность системы.

При таком подходе, появляется необходимость, в наложение результатов работы функций(Function) в
TransientVars. Эта задача решаются с помощью метаданных.

# Общий пример использования метаданных

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

## Маппинг результатов

Вызво сервиса \OldTown\Workflow\ZF2\Service\Behat\Test\Service\TestService::dispatch возвращает массив. Если возникла
потребность использовать результаты работы данного сервиса в дальнейшем, то необходимо что бы эти результаты попали в 
TransientVars.

Это также реализуется с помощью метаданных.

* Можно сохранить результат в TransientVars указав ключ. Т.е TransientVars[$key] = \OldTown\Workflow\ZF2\Service\Behat\Test\Service\TestService::dispatch
* Если \OldTown\Workflow\ZF2\Service\Behat\Test\Service\TestService::dispatch, возвращает массив, то можно наложить этот массив на TransientVars.
При этом есть возможность указать карту соответсвий, какой ключ массива, какому ключу в TransientVars будет соответствовать.



