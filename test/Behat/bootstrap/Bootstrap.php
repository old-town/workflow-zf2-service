<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-serviceEngine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\ServiceEngine\Behat\Test;

use Zend\Loader\AutoloaderFactory;


error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 *
 * @subpackage UnitTest
 */
class Bootstrap
{
    /**
     * @var bool
     */
    protected static $flagInit = false;

    /**
     * Настройка тестов
     *
     * @throws \RuntimeException
     */
    public static function init()
    {
        if (!static::$flagInit) {
            static::initAutoloader();
            static::$flagInit = true;
        }
    }


    /**
     * Инициализация автозагрузчика
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            /** @noinspection PhpIncludeInspection */
            include $vendorPath . '/autoload.php';
        }

        try {
            AutoloaderFactory::factory([
                'Zend\Loader\StandardAutoloader' => [
                    'autoregister_zf' => true,
                    'namespaces' => [
                        'OldTown\\Workflow\\ZF2\\ServiceEngine' =>  __DIR__ . '/../../../src',
                        'OldTown\\Workflow\\ZF2\\ServiceEngine\\Behat\\Test\\Service' => __DIR__ . '/../test-service',
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            $errMsg = 'Ошибка инициации автолоадеров';
            throw new \RuntimeException($errMsg, $e->getCode(), $e);
        }
    }

    /**
     * @param $path
     *
     * @return bool|string
     */
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
