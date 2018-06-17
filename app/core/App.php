<?php


namespace app\core;

class App
{
    public $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Стартуем приложение
     */
    public function start(){
        Router::$defaultController = $this->config->defaultController;
        Router::$defaultAction = $this->config->defaultAction;
        Router::run();
    }
}