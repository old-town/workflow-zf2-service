
# Функционал модуля

Модуль добавляет возможность использовать сервисы ZF2 в workflow. 

Библиотека [old-town-workflow](https://github.com/old-town/old-town-workflow) является портом проекта [OSWorkflow](https://bitbucket.org/opensymphony/osworkflow/src/2d12ee26481f4ba6c9ff35fb3f118191f6d62035?at=default).
Библиотека является самодостаточной, и не нуждается в сторонних framework. При этом работа workflow построенна таким образом,
что функции(Function), условия(Condition), валидаторы(Validator), регистры(Register) - находятся вне библиотеки. 

Для взаимодействия workflow с приложением, предусмотренны TypeResolver. По своей сути TypeResolver это фабрика, которая
на основе типа и аргументов может создавать функции(Function), условия(Condition), валидаторы(Validator), регистры(Register).

В данном модуле реализованы дополнительные TypeResolver:

* \OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolver - резолвер позволяет построить цепочку из множества вложенных резолверов
* \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver - резолвер добавляет поддержку новго типа "service"(сервисы ZF2)

При создание нового объекта менеджера workflow, модулем [old-town/workflow-zf2](https://github.com/old-town/workflow-zf2)
бросается событие workflow.manager.create. Обработка этого события осуществляется \OldTown\Workflow\ZF2\Service\Listener\InjectTypeResolver.
Обработчик:

* Создает \OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolver
* Добавляет в него TypeResolver установленный в менеджер workflow.
* \OldTown\Workflow\ZF2\Service\Listener\InjectTypeResolver с помощью своего EventManager'а бросает собыите inject.workflow.type.resolver,
обработчики данного события должны вернуть объект TypeResolver, который в последствие будет добавлен в ChainTypeResolver
* Обработчки сам подписан на событие inject.workflow.type.resolver, в обработчике возвращается \OldTown\Workflow\ZF2\Service\TypeResolver\ServiceTypeResolver
* Устанавливает в workflow в качестве резолвера \OldTown\Workflow\ZF2\Service\TypeResolver\ChainTypeResolver

Таким образом, при попытки выполнить функцию(Function), валидатор(Validator), условие(Condition) или воспользоваться регистром(Register),
будет произведен обход ChainTypeResolver, где сначала будет отработает резовлер с наивысшим приоритетом(в данном случае ServiceTypeResolver),
и в самую поселеднию очередь резовлер по умолчанию.

# Сервисы
Для работы с сервисам использвется \OldTown\Workflow\ZF2\Service\Service\Manager. Это стандартный PluginManager ZF2. Все сервисы
зарегестрированные в данном менеджере можно использовать в workflow

Сервис не должен знать ничего о workflow. Сам по себе сервис это метод определенного класса. Если у класса есть 
зависимости от другх компонентов системы, то эти зависимости должны быть явно описаны в констукторе класса.

Установка звисимостей осуществляется через фабрику. Таким образом, если сервис требует передачи в констуктор 
зависимых объектов, то сначала регистрируем сервис в \OldTown\Workflow\ZF2\Service\Service\Manager , прописывая
ему нужную фабрику. 

Фабрика имеет доступ к ServiceLocator приложения. Из ServiceLocator извлекаются необходимые данные, и передаются в констуктор.

Такой подходи дает возможность писать код максимально пригодный к тестированию.