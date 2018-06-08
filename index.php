<?php

use app\core\App;
use config\Config;

require_once __DIR__ . "/app/autoload.php";

$config = new Config();
$app = new App($config);
$app->start();