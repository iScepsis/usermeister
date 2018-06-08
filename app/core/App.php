<?php


namespace app\core;

class App
{
    public $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    public function start(){

    }
}