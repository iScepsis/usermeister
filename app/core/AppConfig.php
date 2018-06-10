<?php


namespace app\core;


abstract class AppConfig
{
    public $applicationName = '';
    public $defaultController = '';
    public $defaultAction = '';

    public function __construct(){
        try {
            $this->checkConfiguration();
            //TODO: сделать нормальную обработку ошибок
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
        if (empty($this->applicationName)) throw new \Exception('Default Controller must be set!');
        if (empty($this->applicationName)) throw new \Exception('Default Action must be set!');
    }
}