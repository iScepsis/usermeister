<?php


namespace app\core;


abstract class AppConfig
{
    public $applicationName = '';

    public function __construct(){
        try {
            $this->checkConfiguration();
            //TODO: сделать нормальную обработку ошибок
        } catch (\Exception $e) {
            die('Config error: ' . $e->getMessage() . ' ');
        }

    }

    /**
     * Проверка конфигурации на заполнеие обязательных полей
     * @throws \Exception
     */
    public function checkConfiguration():void {
        if (empty($this->applicationName)) throw new \Exception('Incorrect config! Application Name must be set!');
    }
}