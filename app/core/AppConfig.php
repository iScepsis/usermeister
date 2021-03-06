<?php
/**
 * Шаблон конфигурационных файлов
 */

namespace app\core;


abstract class AppConfig
{
    public $applicationName = '';
    public $defaultController = '';
    public $defaultAction = '';
    public static $rootDir = '';
    public static $viewsDir = '';
    public static $layoutsDir = '';
    public static $maxSelectRowLimit = 1000;

    /**
     * AppConfig constructor.
     * Определяем вычисляемые свойства, проверяем заполнение обязательных полей в конце
     */
    public function __construct(){
        try {
            self::$rootDir = dirname(dirname(__DIR__));
            self::$viewsDir = self::$rootDir . DIRECTORY_SEPARATOR . 'views';
            self::$layoutsDir = self::$viewsDir . DIRECTORY_SEPARATOR . 'layouts';

            $this->checkConfiguration();

        } catch (\Exception $e) {
            die('Config error: ' . $e->getMessage() . ' ');
        }
    }

    /**
     * Проверка конфигурации на заполнение обязательных полей
     * @throws \Exception
     */
    public function checkConfiguration():void {
        if (empty($this->applicationName)) throw new \Exception('Application Name must be set!');
        if (empty($this->defaultController)) throw new \Exception('Default Controller must be set!');
        if (empty($this->defaultAction)) throw new \Exception('Default Action must be set!');
    }
}