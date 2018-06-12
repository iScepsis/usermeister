<?php


namespace config;

use app\core\AppConfig;

class Config extends AppConfig
{
    public $applicationName = 'usermeister';
    public $defaultController = 'user';
    public $defaultAction = 'index';

    public static $db = [
        'host' => 'localhost',
        'dbname' => 'usermeister',
        'user' => 'usermeister',
        'pass' => 'Qwe_123'
    ];
}