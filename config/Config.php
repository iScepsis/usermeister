<?php


namespace config;

use app\core\AppConfig;

class Config extends AppConfig
{
    public $applicationName = 'usermeister';
    public $defaultController = 'user';
    public $defaultAction = 'index';

    public $db = [];
}